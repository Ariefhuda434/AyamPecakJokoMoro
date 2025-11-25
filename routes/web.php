<?php

use App\Models\Customer;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\EmployeeController;

Route::get('/auth/register', function () {
    return view('auth.register');
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


Route::post('/order/add-customer/{table}',[CustomerController::class,'store'])->name('make.customer');


Route::get('/order', [OrderController::class,'index'])->name('order.index');
Route::post('/order/add-order',[OrderController::class,'store'])->name('make.order');
Route::post('/order/add-table',[TableController::class,'table_create'])->name('make.table');



Route::get('/karyawan', [EmployeeController::class,'index'])->name('karyawan.index');
Route::post('/store-karyawan',[EmployeeController::class,'store'])->name('karyawan.store');
Route::delete('/karyawan/{employee}', [EmployeeController::class, 'destroy'])->name('karyawan.destroy');
Route::put('/karyawan/{employee}', [EmployeeController::class, 'update'])->name('karyawan.update');