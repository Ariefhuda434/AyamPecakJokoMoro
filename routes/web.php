<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\RestockLogContoroller;
use App\Http\Controllers\TransactionController;

Route::get('/', [AuthController::class, 'login_view'])->name('auth.login');
Route::post('/login', [AuthController::class, 'login'])->name('login.action');

Route::get('/', [AuthController::class, 'login_view'])->name('login.view');
Route::post('/login', [AuthController::class, 'login'])->name('login.action');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


Route::middleware(['auth'])->group(function () {

    Route::middleware(['role:manager'])->prefix('manager')->group(function () {

        Route::get('/dashboard', [ManagerController::class, 'index'])->name('dashboard.view');
        Route::get('/dashboard/menu-management', [MenuController::class, 'index'])->name('menu.index');
        Route::post('/dashboard/menu-management', [MenuController::class, 'store'])->name('menu.store');
        Route::put('/dashboard/menu-management/{menu}', [MenuController::class, 'update'])->name('menu.update');
        Route::delete('/dashboard/menu-management/{menu}', [MenuController::class, 'destroy'])->name('menu.destroy');

        Route::get('/dashboard/menu-management/recipies/{slug}', [RecipeController::class, 'index'])->name('recipies.index');
        Route::post('/dashboard/menu-management/recipies/{slug}/store', [RecipeController::class, 'store'])->name('recipies.store');
        Route::put('/dashboard/menu-management/recipies/{recipe}', [RecipeController::class, 'update'])->name('recipies.update');
        Route::delete('/dashboard/menu-management/recipies/{recipe}', [RecipeController::class, 'destroy'])->name('recipies.destroy');

        Route::get('/stock', [StockController::class, 'index'])->name('stock.index');
        Route::post('/stock', [StockController::class, 'store'])->name('stock.store');
        Route::put('/stock/{stock}', [StockController::class, 'update'])->name('stock.update');
        Route::delete('/stock/{stock}', [StockController::class, 'destroy'])->name('stock.destroy');

        Route::get('/stock/restock/{slug}', [RestockLogContoroller::class, 'index'])->name('restock.index');
        Route::post('/stock/restock/store', [RestockLogContoroller::class, 'store'])->name('restock.store');
        Route::put('/stock/restock/{restockLog}', [RestockLogContoroller::class, 'update'])->name('restock.update');
        Route::delete('/stock/restock/{restockLog}', [RestockLogContoroller::class, 'destroy'])->name('restock.destroy');

        Route::get('/karyawan', [EmployeeController::class, 'index'])->name('employee.index');
        Route::post('/karyawan', [EmployeeController::class, 'store'])->name('employee.store');
        Route::put('karyawan/{employee}', [EmployeeController::class, 'update'])->name('employee.update');
        Route::delete('karyawan/{employee}', [EmployeeController::class, 'destroy'])->name('employee.destroy');
    });

    Route::middleware(['role:waiter'])->prefix('waiter')->group(function () {

        Route::get('/order',[CustomerController::class,'index'])->name('customer.index');
        Route::post('/order/add-table', [TableController::class, 'table_create'])->name('make.table');
        Route::post('order/add-customer/', [CustomerController::class, 'store'])->name('make.customer');
        Route::put('/order/menu/clear',[CustomerController::class,'out'])->name('customer.out');

        Route::get('/order/menu/{table}/{customer}',[OrderController::class,'index'])->name('order.index');
        Route::post('/order/cart', [OrderController::class, 'addToCart'])->name('cart.add');
        Route::post('/order/checkout', [OrderController::class, 'checkout'])->name('checkout');
        Route::get('/order/{order}/show', [OrderController::class, 'show'])->name('order.show');
        Route::get('/order/{order}/show/print', [OrderController::class, 'printStruk'])->name('order.print');
    });

    Route::middleware(['role:cashier'])->group(function () {    
        Route::get('/transactions', [TransactionController::class, 'index'])->name('cashier.view');
        Route::post('/transactions/payment', [TransactionController::class, 'payment'])->name('cashier.pay');
        Route::get('/transactions/payment/{transaction}', [TransactionController::class, 'paymentindex'])->name('payment.index');
    });
});
