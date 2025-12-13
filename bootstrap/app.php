<?php

use App\Models\Employee;
use Illuminate\Foundation\Application;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Controllers\AuthController;
use Illuminate\Auth\Middleware\Authenticate;
use App\Http\Middleware\SetDatabaseConnection;
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
            'auth' => Authenticate::class,
            'role' => RoleMiddleware::class, 
        ]);
        $middleware->web(prepend: [
             SetDatabaseConnection::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
    })->create();
