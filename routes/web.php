<?php

use Illuminate\Support\Facades\Route;

Route::get('/auth/register', function () {
    return view('auth.register');
});
Route::get('/', function () {
    return view('auth.login');
});
Route::get('/order', function () {
    return view('order');
});
Route::get('/order/menu', function () {
    return view('menu');
});
Route::get('/dashboard', function () {
    return view('dashboard');
});

