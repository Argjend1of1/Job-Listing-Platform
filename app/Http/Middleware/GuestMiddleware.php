<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\JsonResponse;

class GuestMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            // Force a JSON response if request is from API
            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json([
                    'message' => 'Already authenticated.'
                ], 403);
            }

            // Fallback for web routes
            abort(403, 'Already authenticated.');
        }

        return $next($request);
    }
}

