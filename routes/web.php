<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;

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





Route::get('/karyawan', [EmployeeController::class,'index'])->name('karyawan.index');
Route::post('/store-karyawan',[EmployeeController::class,'store'])->name('karyawan.store');
Route::delete('/karyawan/{employee}', [EmployeeController::class, 'destroy'])->name('karyawan.destroy');
Route::put('/karyawan/{employee}', [EmployeeController::class, 'update'])->name('karyawan.update');