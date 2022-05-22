<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth()->guard('api')->check() && auth()->guard('api')->user()->role == 2) {
            return $next($request);
        }
        return response()->json([
            'status' => 'error',
            'message' => 'access denied',
            'data' => [
                'have_access' =>  auth()->guard('api')->check()
            ]
        ], 403);
    }
}
