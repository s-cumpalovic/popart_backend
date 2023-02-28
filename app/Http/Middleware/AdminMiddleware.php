<?php

namespace App\Http\Middleware;

use Closure;
class AdminMiddleware
{
    public function handle($request, Closure $next)
    {
        if (auth()->user() && auth()->user()->role == 'admin') {
            return $next($request);
            dd(auth()->user()->role);
        }

        return response()->json(['message' => 'Unauthorized'], 401);
    }
}
