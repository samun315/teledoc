<?php

use App\Http\Controllers\Marchant\BalanceRequestApproveController;
use App\Http\Controllers\Marchant\BalanceRequestController;
use Illuminate\Support\Facades\Route;
// marchant.balance.request.index

Route::group(['prefix' => 'balance/request'], function () {
    Route::get('/', [BalanceRequestController::class, 'index'])->name('index');
    Route::post('/store', [BalanceRequestController::class, 'store'])->name('store');
});


Route::group(['prefix' => 'all/balance/request', 'as' => 'approve.'], function () {
    Route::get('/', [BalanceRequestApproveController::class, 'index'])->name('index');
    Route::put('/update-status/{id}', [BalanceRequestApproveController::class, 'updateStatus'])->name('updateStatus');
});