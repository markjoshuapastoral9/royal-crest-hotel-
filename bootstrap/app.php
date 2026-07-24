<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

$app = Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Trust all proxies (required for Railway / any reverse proxy)
        $middleware->trustProxies(at: '*');

        $middleware->alias([
            'admin'       => \App\Http\Middleware\AdminMiddleware::class,
            'active.user' => \App\Http\Middleware\ActiveUserMiddleware::class,
        ]);

        $middleware->web(append: [
            \App\Http\Middleware\ActiveUserMiddleware::class,
            \App\Http\Middleware\SetLocale::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();

// Register Resend custom transport
$app->extend('mail.manager', function ($manager) {
    $manager->extend('resend', function () {
        return new \App\Mail\ResendTransport();
    });
    return $manager;
});

return $app;
