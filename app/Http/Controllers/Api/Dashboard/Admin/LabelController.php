<?php

namespace App\Http\Controllers\Api\Dashboard\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Admin\Label\StoreRequest;
use App\Http\Requests\Dashboard\Admin\Label\UpdateRequest;
use App\Http\Resources\Label\LabelResource;
use App\Models\Label;
use Exception;
use Illuminate\Http\JsonResponse;

class LabelController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json(LabelResource::collection(Label::all()));
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
        $label = new Label();
        $label->name = $request->get('name');
        $label->color = $request->get('color');
        if ($label->save()) {
            return response()->json(['message' => 'Data saved correctly', 'label' => new LabelResource($label)]);
        }
        return response()->json(['message' => __('An error occurred while saving data')], 500);
    }

    /**
     * Display the specified resource.
     *
     * @param  Label  $label
     * @return JsonResponse
     */
    public function show(Label $label): JsonResponse
    {
        return response()->json(new LabelResource($label));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateRequest  $request
     * @param  Label  $label
     * @return JsonResponse
     */
    public function update(UpdateRequest $request, Label $label): JsonResponse
    {
        $request->validated();
        $label->name = $request->get('name');
        $label->color = $request->get('color');
        if ($label->save()) {
            return response()->json(['message' => 'Data updated correctly', 'label' => new LabelResource($label)]);
        }
        return response()->json(['message' => __('An error occurred while saving data')], 500);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Label  $label
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(Label $label): JsonResponse
    {
        $label->tickets()->sync([]);
        if ($label->delete()) {
            return response()->json(['message' => 'Data deleted successfully']);
        }
        return response()->json(['message' => __('An error occurred while deleting data')], 500);
    }
}
