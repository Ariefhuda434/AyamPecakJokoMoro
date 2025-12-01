<?php

use App\Models\Customer;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\TransactionController;

Route::get('/', [AuthController::class,'login_view'])->name('auth.login');
Route::post('/login', [AuthController::class,'login'])->name('login.action');
Route::resource('menu', MenuController::class);




Route::middleware(['auth'])->group(function () {

    Route::post('/logout', [AuthController::class,'logout'])->name('logout');

    Route::middleware('role:manager')->group(function () {
        Route::post('/order/add-table',[TableController::class,'table_create'])->name('make.table');
        Route::put('/karyawan/{employee}', [EmployeeController::class, 'update'])->name('karyawan.update');
        Route::post('/store-karyawan',[EmployeeController::class,'store'])->name('karyawan.store');
        Route::delete('/karyawan/{employee}', [EmployeeController::class, 'destroy'])->name('karyawan.destroy');
        Route::get('/dashboard', [ManagerController::class, 'index'])->name('dashboard.view');
        Route::get('/karyawan', [EmployeeController::class,'index'])->name('karyawan.index');
        Route::get('/stock', function () {return view('stock');})->name('stock');
    });
    Route::middleware('role:waiter')->group(function () {
        Route::get('/order', [OrderController::class, 'index'])->name('order.index');  
        Route::post('/order/add-order',[OrderController::class,'store'])->name('make.order');
        Route::get('/order/menu', function () {return view('menu');});
        Route::post('/order/add-customer/{table}',[CustomerController::class,'store'])->name('make.customer');

    });
    Route::middleware('role:cashier')->group(function () {
        Route::get('/transactions', [TransactionController::class, 'index'])->name('cashier.view')->middleware('role:cashier');
        
    });
});







