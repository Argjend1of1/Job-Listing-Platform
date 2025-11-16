<?php

use App\Http\Middleware\GuestMiddleware;
use App\Http\Middleware\HandleInertiaRequests;
use App\Http\Middleware\RoleCheckMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;
use Symfony\Component\HttpFoundation\Response;


return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {

        $middleware->alias([
            'web'           => StartSession::class,
            'csrf'          => VerifyCsrfToken::class,
            'role'          => RoleCheckMiddleware::class,
            'auth:sanctum'  => EnsureFrontendRequestsAreStateful::class,
            'guest:sanctum' => GuestMiddleware::class
        ]);

        $middleware->group('api', [
            EnsureFrontendRequestsAreStateful::class,
            SubstituteBindings::class,
        ]);

        $middleware->web(append: [
            HandleInertiaRequests::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->respond(function (Response $response) {
            $status = $response->getStatusCode();

            // ✅ Handle CSRF (419)
            if ($status === 419) {
                return back()->with([
                    'message' => 'The page expired, please try again.',
                ]);
            }

            // ✅ Handle Forbidden (403)
            if ($status === 403) {
                return redirect('/')->with([
                    'error' => 'You are not authorized to perform that action.',
                ]);
            }

            // ✅ Handle Not Found (404)
            if ($status === 404) {
                return redirect('/')->with([
                    'error' => 'The page you were looking for could not be found.',
                ]);
            }
//
//            // ✅ Handle Too Many Requests (429)
//            if ($status === 429) {
//                return back()->with([
//                    'error' => 'You have made too many requests. Please slow down.',
//                ]);
//            }
//
//            // ✅ Optionally handle 500 errors gracefully
//            if ($status >= 500) {
//                Log::error('Server error: ' . $status);
//                return redirect()->route('home')->with([
//                    'error' => 'Something went wrong on our end. Please try again later.',
//                ]);
//            }

            // Default: return the response untouched
            return $response;
        });
    })->create();
