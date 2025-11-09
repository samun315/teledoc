<?php

use App\Http\Controllers\Service\ServiceController;
use Illuminate\Support\Facades\Route;

// service
// name route  service.service.index
// url /service/service
Route::group(['prefix' => 'service', 'as' => 'service.'], function () {
    Route::get('/', [ServiceController::class, 'index'])->name('index');
    Route::get('/create', [ServiceController::class, 'create'])->name('create');
    Route::post('/store', [ServiceController::class, 'store'])->name('store');
    Route::get('/edit/{service_id}', [ServiceController::class, 'edit'])->name('edit');
    Route::put('/update/{service_id}', [ServiceController::class, 'update'])->name('update');
    Route::delete('/delete/{service_id}', [ServiceController::class, 'destroy'])->name('delete');
});

