<?php

namespace App\Http\Controllers\Api\Dashboard\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Admin\Language\StoreRequest;
use App\Http\Requests\Dashboard\Admin\Language\UpdateRequest;
use App\Http\Resources\Language\LanguageResource;
use App\Models\Language;
use Artisan;
use Exception;
use File;
use Illuminate\Http\JsonResponse;

class LanguageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
        $this->middleware('demo', ['only' => ['store', 'update', 'destroy', 'sync']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json(LanguageResource::collection(Language::all()));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreRequest  $request
     * @return JsonResponse
     */
    public function store(StoreRequest $request): JsonResponse
    {
        $request->validated();
        $language = new Language();
        $language->locale = $request->get('locale');
        $language->name = $request->get('name');
        if ($language->save()) {
            Artisan::call('translatable:export', ['lang' => $language->locale]);
            return response()->json(['message' => __('Data saved correctly'), 'language' => new LanguageResource($language)]);
        }
        return response()->json(['message' => __('An error occurred while saving data')], 500);
    }

    /**
     * Display the specified resource.
     *
     * @param  Language  $language
     * @return JsonResponse
     * @throws Exception
     */
    public function show(Language $language): JsonResponse
    {
        if (file_exists(base_path().'/resources/lang/'.$language->locale.'.json')) {
            $translations = [];
            foreach (json_decode(File::get(base_path().'/resources/lang/'.$language->locale.'.json'), true, 512, JSON_THROW_ON_ERROR) as $key => $value) {
                $translations[] = ['key' => $key, 'value' => $value];
            }
            return response()->json(['language' => new LanguageResource($language), 'translations' => $translations]);
        }
        return response()->json(['message' => __('No translations found for the selected language')], 500);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateRequest  $request
     * @param  Language  $language
     * @return JsonResponse
     * @throws Exception
     */
    public function update(UpdateRequest $request, Language $language): JsonResponse
    {
        $request->validated();
        $translations = json_decode(File::get(base_path().'/resources/lang/'.$language->locale.'.json'), true, 512, JSON_THROW_ON_ERROR);
        foreach ($request->get('strings') as $string) {
            $translations[$string['key']] = $string['value'];
        }
        if (File::put(base_path().'/resources/lang/'.$language->locale.'.json', json_encode($translations, JSON_THROW_ON_ERROR))) {
            return response()->json(['message' => 'Data updated correctly', 'language' => new LanguageResource($language)]);
        }
        return response()->json(['message' => __('An error occurred while saving data')], 500);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Language  $language
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(Language $language): JsonResponse
    {
        if ($language->locale !== config('app.locale')) {
            if (File::delete(base_path().'/resources/lang/'.$language->locale.'.json')) {
                $language->delete();
                return response()->json(['message' => 'Data deleted successfully']);
            }
            return response()->json(['message' => __('An error occurred while deleting data')], 500);
        }
        return response()->json(['message' => __('Can\'t delete default language')], 406);
    }

    public function sync(): JsonResponse
    {
        try {
            $languages = Language::all();
            foreach ($languages as $index => $language) {
                @Artisan::call('translatable:export', ['lang' => $language->locale]);
            }
            return response()->json(['message' => 'Translation files updated correctly']);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
