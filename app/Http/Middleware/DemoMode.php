<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class DemoMode
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
        if (env('DEMO', false)) {
            return response()->json(['message' => 'Action disabled in demo'], 403);
        }
        return $next($request);
    }
}
