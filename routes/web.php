<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;

Route::get('/auth/register', function () {
    return view('auth.register');
});


Route::get('/order', function () {
    return view('order');
});
Route::get('/order/menu', function () {
    return view('menu');
});
Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard.view');


Route::get('/', [AuthController::class,'login_view'])->name('auth.login');
Route::post('/', [AuthController::class,'login'])->name('login.action');

Route::get('/stock', function () {
    return view('stock');
})->name('stock');

Route::get('/karyawan', [EmployeeController::class,'index'])->name('karyawan.index');
Route::post('/store-karyawan',[EmployeeController::class,'store'])->name('karyawan.store');
Route::delete('/karyawan/{employee}', [EmployeeController::class, 'destroy'])->name('karyawan.destroy');
Route::put('/karyawan/{employee}', [EmployeeController::class, 'update'])->name('karyawan.update');