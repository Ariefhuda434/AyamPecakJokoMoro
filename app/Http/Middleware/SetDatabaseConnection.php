<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Symfony\Component\HttpFoundation\Response;

class SetDatabaseConnection
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $employee = Auth::user();
            $roleSlug = $employee->role->slug ?? null; 

            switch ($roleSlug) {
                case 'kasir':
                    Config::set('database.default', 'mysql_kasir');
                    break;
                case 'waiter':
                    Config::set('database.default', 'mysql_waiter');
                    break;
            }
        }
        return $next($request);
    }
}
