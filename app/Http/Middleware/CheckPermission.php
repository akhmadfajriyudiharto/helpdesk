<?php

namespace App\Http\Middleware;

use App\Models\User;
use Auth;
use Closure;
use Exception;
use Illuminate\Http\Request;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  Closure  $next
     * @return mixed
     * @throws Exception
     */
    public function handle($request, Closure $next)
    {
        if (strpos($request->route()->uri, 'api/dashboard') !== false) {
            if (!Auth::guard('sanctum')->check()) {
                return response()->json(['message' => __('Unauthorized')], 401);
            }
            /** @var User $user */
            $user = Auth::guard('sanctum')->user();
            $path = str_replace('\\', '.', explode('@', str_replace($request->route()->action['controller'].'\\', '', $request->route()->action['controller']))[0]);
            if (!$user->userRole->checkPermission($path)) {
                return response()->json(['message' => __('Forbidden')], 403);
            }
        }
        return $next($request);
    }
}
