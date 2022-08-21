<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Setting;

class PreventRegister
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!e(Setting::get('app_user_registration') ? true : false)) {
            return response()->json(['message' => __('Forbidden')], 403);
        }
        return $next($request);
    }
}
