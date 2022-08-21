<?php

namespace App\Http\Controllers\Api\Dashboard\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Admin\Priority\UpdateRequest;
use App\Http\Resources\Priority\PriorityResource;
use App\Models\Priority;
use Illuminate\Http\JsonResponse;

class PriorityController extends Controller
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
        return response()->json(PriorityResource::collection(Priority::orderBy('value')->get()));
    }

    /**
     * Display the specified resource.
     *
     * @param  Priority  $priority
     * @return JsonResponse
     */
    public function show(Priority $priority): JsonResponse
    {
        return response()->json(new PriorityResource($priority));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateRequest  $request
     * @param  Priority  $priority
     * @return JsonResponse
     */
    public function update(UpdateRequest $request, Priority $priority): JsonResponse
    {
        $request->validated();
        $priority->name = $request->get('name');
        $priority->value = $request->get('value');
        if ($priority->save()) {
            return response()->json(['message' => 'Data updated correctly', 'priority' => new PriorityResource($priority)]);
        }
        return response()->json(['message' => __('An error occurred while saving data')], 500);
    }
}
