<?php

use App\Http\Middleware\GuestMiddleware;
use App\Http\Middleware\RoleCheckMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
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
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
