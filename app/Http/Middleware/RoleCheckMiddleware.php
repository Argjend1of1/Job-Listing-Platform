<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use function PHPUnit\Framework\returnArgument;


class RoleCheckMiddleware
{

    public function handle($request, Closure $next, ...$roles)
    {

        if (!Auth::user() || !in_array(Auth::user()->role, $roles)) {
            // If it's an API request, return 403
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Unauthorized: Insufficient permissions.'
                ], 403);
            }

            // Otherwise, redirect for web requests
            return redirect('/');
        }

//        if in_array pass the request along through the callback $next
        return $next($request);
    }
}
