<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();

    $app->singleton(
        Illuminate\Contracts\Debug\ExceptionHandler::class,
        function ($app) {
            return new class($app) extends Illuminate\Foundation\Exceptions\Handler {
                protected function unauthenticated($request, \Illuminate\Auth\AuthenticationException $exception)
                {
                    if ($request->expectsJson()) {
                        return response()->json(['message' => 'No login yet'], 401);
                    }
    
                    return redirect()->guest(route('login'));
                }
            };
        }
    );