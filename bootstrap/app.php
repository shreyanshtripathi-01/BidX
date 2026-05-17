<?php

// Prevent Nixpacks build-time configuration cache poisoning by deleting the cache file programmatically on boot.
if (file_exists(__DIR__.'/cache/config.php')) {
    @unlink(__DIR__.'/cache/config.php');
}

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
->withMiddleware(function (Middleware $middleware): void {
         $middleware->alias([
             'admin' => \App\Http\Middleware\Admin::class,
         ]);
     })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
