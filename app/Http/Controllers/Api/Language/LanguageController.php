<?php

namespace App\Http\Controllers\Api\Language;

use App\Http\Controllers\Controller;
use App\Http\Resources\Language\LanguageResource;
use App\Models\Language;
use Exception;
use File;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Http\JsonResponse;

class LanguageController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function list(): JsonResponse
    {
        return response()->json(LanguageResource::collection(Language::all()));
    }

    /**
     * @param  string  $locale
     * @return JsonResponse
     * @throws FileNotFoundException
     * @throws Exception
     */
    public function get(string $locale): JsonResponse
    {
        /** @var Language $language */
        if (!$language = Language::where('locale', $locale)->first()) {
            return response()->json(['message' => __('The selected language does not exist')], 404);
        }
        $languageFile = base_path('resources/lang/'.$language->locale.'.json');
        if (File::exists($languageFile)) {
            return response()->json(json_decode(File::get($languageFile), true, 512, JSON_THROW_ON_ERROR));
        }
        return response()->json(['message' => __('The selected language does not exist')], 404);
    }
}
