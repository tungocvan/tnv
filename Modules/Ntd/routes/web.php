<?php

use Illuminate\Support\Facades\Route;
use Modules\Ntd\Http\Controllers\NtdController;

Route::middleware(['web','auth:admin'])
    ->prefix('/admin/ntd')
    ->name('admin.ntd.')
    ->group(function () {
        Route::get('/', [NtdController::class, 'admin'])->name('index');
});

Route::middleware(['web'])
    ->prefix('/ntd')
    ->name('ntd.')
    ->group(function () {
        Route::get('/', [NtdController::class, 'index'])->name('index');
});