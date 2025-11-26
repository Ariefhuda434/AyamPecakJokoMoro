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



Route::get('/order/menu', function () {
    return view('menu');
});

//show login
Route::get('/', [AuthController::class,'login_view'])->name('auth.login');
//post login
Route::post('/', [AuthController::class,'login'])->name('login.action');
Route::get('/dashboard', function () {return view('dashboard');})->name('dashboard.view');
Route::get('/transactions', function () {return view('transaksi');})->name('transaksi.view');

Route::middleware(['auth'])->group(function () {
    Route::middleware(['role:manager'])->group(function () {

        Route::post('/order/add-table',[TableController::class,'table_create'])->name('make.table');
        // Route::get('/dashboard', [ManagerController::class, 'index'])->name('dashboard.view');
        
        Route::get('/karyawan', [EmployeeController::class,'index'])->name('karyawan.index');
        Route::post('/store-karyawan',[EmployeeController::class,'store'])->name('karyawan.store');
        Route::delete('/karyawan/{employee}', [EmployeeController::class, 'destroy'])->name('karyawan.destroy');
        Route::put('/karyawan/{employee}', [EmployeeController::class, 'update'])->name('karyawan.update');

        Route::get('/stock', function () {return view('stock');})->name('stock');
        
    });
    Route::middleware(['role:cashier'])->group(function () {

        // Route::get('/transactions', [TransactionController::class, 'index'])->name('cashier.view');
    });
    Route::middleware(['role:waiter'])->group(function () {  

        Route::get('/orders', [OrderController::class, 'index'])->name('order.index');
        Route::post('/order/add-order',[OrderController::class,'store'])->name('make.order');
        Route::post('/order/add-customer/{table}',[CustomerController::class,'store'])->name('make.customer');
    });
});






