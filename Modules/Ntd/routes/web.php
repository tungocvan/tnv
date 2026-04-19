<?php

use Illuminate\Support\Facades\Route;
use Modules\Ntd\Http\Controllers\NtdController;

Route::middleware(['web', 'auth:admin'])
    ->prefix('admin/ntd/applications')
    ->name('admin.ntd.applications.')
    ->group(function () {

    
        Route::get('/', [NtdController::class, 'list'])
            ->name('index');

       
        Route::get('/create', [NtdController::class, 'create'])
            ->name('create');

       
        Route::get('/{id}', [NtdController::class, 'show'])
            ->name('show');

     
        Route::get('/{id}/edit', [NtdController::class, 'edit'])
            ->name('edit');

        Route::get('/{id}/preview', [NtdController::class, 'preview'])->name('preview');
        Route::get('/{id}/export', [NtdController::class, 'export'])->name('export');

        Route::post('/{id}/export', [NtdController::class, 'export'])
            ->name('export');
        
        

    });
Route::middleware(['web'])
    ->prefix('/ntd')
    ->name('ntd.')
    ->group(function () {
        Route::get('/', [NtdController::class, 'index'])->name('index');
});