<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckGetMethod
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
        if ($request->method() !== 'GET') {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid request method. Only GET requests are allowed.'
            ], 405);
        }

        return $next($request);
    }
}
