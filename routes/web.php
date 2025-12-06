<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\TransactionController;


Route::get('/', [AuthController::class, 'login_view'])->name('login.view');
Route::post('/login', [AuthController::class, 'login'])->name('login.action');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


Route::middleware(['auth'])->group(function () {
    
    Route::middleware(['role:manager'])->prefix('manager')->group(function () {
        
    Route::get('/dashboard', [ManagerController::class, 'index'])->name('dashboard.view');
        
    Route::get('/stock', function () {
    return view('stock');
    })->name('stock.index'); 
        
    Route::get('/karyawan', [EmployeeController::class, 'index'])->name('employee.index');
    Route::post('/karyawan/add-karyawan', [EmployeeController::class, 'store'])->name('employee.store');
    Route::put('karyawan/edit/{employee}', [EmployeeController::class, 'update'])->name('employee.update');
    Route::delete('karyawan/delete/{employee}', [EmployeeController::class, 'destroy'])->name('employee.destroy');
    });

    Route::middleware(['role:waiter'])->prefix('order')->name('order.')->group(function () {
        
        Route::get('/order', [OrderController::class, 'index'])->name('index');
        Route::post('/order/add-order', [OrderController::class, 'store'])->name('make.order');
        Route::post('/order/add-table', [TableController::class, 'table_create'])->name('make.table');
        
        Route::get('/menu', function () {
            return view('menu');
        })->name('menu'); 

        Route::post('/add-customer/{table}', [CustomerController::class, 'store'])->name('make.customer');
    });

    Route::middleware(['role:cashier'])->group(function () {
        Route::get('/transactions', [TransactionController::class, 'index'])->name('cashier.view');
    });

});