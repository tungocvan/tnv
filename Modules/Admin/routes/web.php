<?php

use Illuminate\Support\Facades\Route;
use Modules\Admin\Http\Controllers\DashboardController;


use Modules\Admin\Http\Controllers\MenuController;

use Modules\Admin\Http\Controllers\OrderController;
use Modules\Admin\Http\Controllers\SettingController;



Route::middleware(['web'])->group(function () {


    Route::middleware(['web', 'auth:admin'])->prefix('admin')->name('admin.')->group(function () { // Sau này thêm middleware admin sau
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        // === QUẢN LÝ MENU ===
        Route::prefix('menus')->name('menus.')->group(function () {
            Route::get('/', [MenuController::class, 'index'])->name('index');
            Route::get('/create', [MenuController::class, 'create'])->name('create');
            Route::get('/{id}/edit', [MenuController::class, 'edit'])->name('edit');
        });


        Route::prefix('orders')->name('orders.')->group(function () {
            Route::get('/', [OrderController::class, 'index'])->name('index');
            Route::get('/{id}', [OrderController::class, 'show'])->name('show');
            Route::get('/{id}/print', [OrderController::class, 'print'])->name('print');
            Route::get('/{id}/pdf', [OrderController::class, 'exportPdf'])->name('pdf');
        });

        Route::get('/profile', [SettingController::class, 'profile'])->name('profile');


    });
});
