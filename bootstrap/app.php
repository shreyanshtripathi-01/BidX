<?php

if (file_exists(__DIR__.'/cache/config.php')) {
    @unlink(__DIR__.'/cache/config.php');
}

$mappings = [
    'DB_HOST' => ['MYSQLHOST', 'MYSQL_HOST'],
    'DB_PORT' => ['MYSQLPORT', 'MYSQL_PORT'],
    'DB_DATABASE' => ['MYSQLDATABASE', 'MYSQL_DATABASE'],
    'DB_USERNAME' => ['MYSQLUSER', 'MYSQL_USER', 'MYSQLUSERNAME'],
    'DB_PASSWORD' => ['MYSQLPASSWORD', 'MYSQL_PASSWORD'],
];

foreach ($mappings as $laravelVar => $railwayVars) {
    $currentVal = getenv($laravelVar);
    if ($currentVal === false || $currentVal === '') {
        foreach ($railwayVars as $railwayVar) {
            $railwayVal = getenv($railwayVar);
            if ($railwayVal !== false && $railwayVal !== '') {
                $_ENV[$laravelVar] = $railwayVal;
                $_SERVER[$laravelVar] = $railwayVal;
                putenv("{$laravelVar}={$railwayVal}");
                break;
            }
        }
    }
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
    })->create();
