<?php

use App\Http\Middleware\EnsureTwoFactorAuthenticated;
use App\Http\Middleware\RestrictByRole;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web/main.php',
        commands: __DIR__ . '/../routes/console/main.php',
        channels: __DIR__ . '/../routes/channels.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'role' => RestrictByRole::class,
            '2fa' => EnsureTwoFactorAuthenticated::class
        ]);
        $middleware->web(append: [
            \App\Http\Middleware\UpdateLastLogin::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
