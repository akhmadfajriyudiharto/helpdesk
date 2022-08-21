<?php

namespace App\Http\Controllers\Api\Dashboard\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Admin\Status\UpdateRequest;
use App\Http\Resources\Status\StatusResource;
use App\Models\Status;
use Illuminate\Http\JsonResponse;

class StatusController extends Controller
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
        return response()->json(StatusResource::collection(Status::all()));
    }

    /**
     * Display the specified resource.
     *
     * @param  Status  $status
     * @return JsonResponse
     */
    public function show(Status $status): JsonResponse
    {
        return response()->json(new StatusResource($status));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateRequest  $request
     * @param  Status  $status
     * @return JsonResponse
     */
    public function update(UpdateRequest $request, Status $status): JsonResponse
    {
        $request->validated();
        $status->name = $request->get('name');
        if ($status->save()) {
            return response()->json(['message' => 'Data updated correctly', 'status' => new StatusResource($status)]);
        }
        return response()->json(['message' => __('An error occurred while saving data')], 500);
    }
}
