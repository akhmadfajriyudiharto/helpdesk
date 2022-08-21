<?php

namespace App\Http\Controllers\Api\Dashboard\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Admin\Department\StoreRequest;
use App\Http\Requests\Dashboard\Admin\Department\UpdateRequest;
use App\Http\Resources\Department\DepartmentDetailsResource;
use App\Http\Resources\Department\DepartmentResource;
use App\Http\Resources\User\UserDetailsResource;
use App\Models\Department;
use App\Models\Ticket;
use App\Models\User;
use App\Models\UserRole;
use Exception;
use Illuminate\Http\JsonResponse;

class DepartmentController extends Controller
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
        return response()->json(DepartmentDetailsResource::collection(Department::all()));
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
        $department = new Department();
        $department->name = $request->get('name');
        $department->all_agents = $request->get('all_agents');
        $department->public = $request->get('public');
        $agents = [];
        if (!$department->all_agents) {
            $agents = $request->get('agents');
        }
        if ($department->save()) {
            $department->agent()->sync($agents);
            return response()->json(['message' => 'Data saved correctly', 'department' => new DepartmentResource($department)]);
        }
        return response()->json(['message' => __('An error occurred while saving data')], 500);
    }

    /**
     * Display the specified resource.
     *
     * @param  Department  $department
     * @return JsonResponse
     */
    public function show(Department $department): JsonResponse
    {
        return response()->json(new DepartmentResource($department));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateRequest  $request
     * @param  Department  $department
     * @return JsonResponse
     */
    public function update(UpdateRequest $request, Department $department): JsonResponse
    {
        $request->validated();
        $department->name = $request->get('name');
        $department->all_agents = $request->get('all_agents');
        $department->public = $request->get('public');
        $agents = [];
        if (!$department->all_agents) {
            $agents = $request->get('agents');
        }
        if ($department->save()) {
            $department->agent()->sync($agents);
            return response()->json(['message' => 'Data updated correctly', 'department' => new DepartmentResource($department)]);
        }
        return response()->json(['message' => __('An error occurred while saving data')], 500);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Department  $department
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(Department $department): JsonResponse
    {
        Ticket::where('department_id', $department->id)->update(['department_id' => null]);
        $department->agent()->sync([]);
        if ($department->delete()) {
            return response()->json(['message' => 'Data deleted successfully']);
        }
        return response()->json(['message' => __('An error occurred while deleting data')], 500);
    }

    public function users()
    {
        $roles = UserRole::where('dashboard_access', true)->pluck('id');
        $agents = User::whereIn('role_id', $roles)->where('status', true)->get();
        return response()->json(UserDetailsResource::collection($agents));
    }
}
