<?php

namespace App\Http\Controllers\Api\Dashboard\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Admin\UserRole\StoreRequest;
use App\Http\Requests\Dashboard\Admin\UserRole\UpdateRequest;
use App\Http\Resources\UserRole\UserRoleEditResource;
use App\Http\Resources\UserRole\UserRoleResource;
use App\Models\User;
use App\Models\UserRole;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Route;
use Setting;
use Str;

class UserRoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
        $this->middleware('demo', ['only' => ['store', 'update', 'destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param  Request  $request
     * @return JsonResponse
     * @throws Exception
     */
    public function index(Request $request): JsonResponse
    {
        $sort = json_decode($request->get('sort', json_encode(['order' => 'asc', 'column' => 'created_at'], JSON_THROW_ON_ERROR)), true, 512, JSON_THROW_ON_ERROR);
        $items = UserRole::filter($request->all())
            ->orderBy($sort['column'], $sort['order'])
            ->get();
        return response()->json(['items' => UserRoleResource::collection($items)]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreRequest  $request
     * @return JsonResponse
     * @throws Exception
     */
    public function store(StoreRequest $request): JsonResponse
    {
        $request->validated();
        $userRole = new UserRole();
        $userRole->name = $request->get('name');
        $userRole->dashboard_access = $request->get('dashboard_access');
        $userRole->type = 2;
        $userRole->permissions = json_encode(str_replace('\'"', '"', $request->get('permissions')), JSON_THROW_ON_ERROR);
        if ($userRole->save()) {
            return response()->json(['message' => __('Data saved correctly'), 'userRole' => new UserRoleEditResource($userRole)]);
        }
        return response()->json(['message' => __('An error occurred while saving data')], 500);
    }

    /**
     * Display the specified resource.
     *
     * @param  UserRole  $userRole
     * @return JsonResponse
     */
    public function show(UserRole $userRole): JsonResponse
    {
        if ($userRole->type === 1) {
            return response()->json(['message' => __('Cannot edit a system base function')], 406);
        }
        return response()->json(new UserRoleEditResource($userRole));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateRequest  $request
     * @param  UserRole  $userRole
     * @return JsonResponse
     * @throws Exception
     */
    public function update(UpdateRequest $request, UserRole $userRole): JsonResponse
    {
        $request->validated();
        $userRole->name = $request->get('name');
        $userRole->dashboard_access = $request->get('dashboard_access');
        $userRole->permissions = json_encode(str_replace('\'"', '"', $request->get('permissions')), JSON_THROW_ON_ERROR);
        if ($userRole->save()) {
            return response()->json(['message' => 'Data updated correctly', 'userRole' => new UserRoleEditResource($userRole)]);
        }
        return response()->json(['message' => __('An error occurred while saving data')], 500);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  UserRole  $userRole
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(UserRole $userRole): JsonResponse
    {
        if ($userRole->type !== 2 || ($userRole->id === (int) Setting::get('app_default_role'))) {
            return response()->json(['message' => __('Can not delete a default role')], 406);
        }
        User::where('role_id', $userRole->id)->update(['role_id' => Setting::get('app_default_role')]);
        if ($userRole->delete()) {
            return response()->json(['message' => 'Data deleted successfully']);
        }
        return response()->json(['message' => __('An error occurred while deleting data')], 500);
    }

    /**
     * @return JsonResponse
     * @throws Exception
     */
    public function permissions(): JsonResponse
    {
        $permissionsLabels = [];
        $permissionsKeys = [];
        foreach (Route::getRoutes()->getIterator() as $route) {
            if (strpos($route->uri, 'api/dashboard') !== false) {
                $path = explode('@', str_replace($route->action['controller'].'\\', '', $route->action['controller']))[0];
                $pathName = str_replace(['App\\Http\\Controllers\\Api\\', 'Controller', '\\'], '', $path);
                $key = str_replace('\\', '.', $path);
                $label = 'Manage'.strtolower(implode(' ', preg_split('/(?=[A-Z])/', Str::plural($pathName))));
                if (!in_array($key, $permissionsKeys, true)) {
                    $permissionsKeys[] = $key;
                }
                $permissionsLabels[$key] = $label;
            }
        }
        return response()->json(['keys' => $permissionsKeys, 'labels' => $permissionsLabels]);
    }
}
