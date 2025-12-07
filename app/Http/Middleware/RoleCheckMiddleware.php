<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class RoleCheckMiddleware
{

    public function handle(Request $request, Closure $next, ...$roles)
    {
        /** @var User $user */
        $user = Auth::user();

        if (!Auth::user() || !in_array($user->role, $roles)) {
            // If it's an API request, return 403
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Unauthorized: Insufficient permissions.'
                ], 403);
            }

            // Otherwise, redirect for web requests
            return redirect('/')->with(
                'message', 'You are not authorized for this action!'
            );
        }

//        if in_array pass the request along through the callback $next
        return $next($request);
    }
}
