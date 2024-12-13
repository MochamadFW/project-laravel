<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        if (!$request->user() || !$request->user()->hasRole('superadmin')) {
            return response()->json([
                'status' => false,
                'message' => 'Access denied/Unauthorized.'
            ])->setStatusCode(403);
        }

        return $next($request);
    }
}