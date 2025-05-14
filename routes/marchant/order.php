<?php

use App\Http\Controllers\Marchant\OrderBalanceApproveController;
use App\Http\Controllers\Marchant\OrderBalanceController;
use Illuminate\Support\Facades\Route;
// marchant.order.balance.index

Route::group(['prefix' => 'order/balance'], function () {
    Route::get('/', [OrderBalanceController::class, 'index'])->name('index');
    Route::get('/create', [OrderBalanceController::class, 'create'])->name('create');
    Route::get('/gateway-info/{gateway_id}', [OrderBalanceController::class, 'gatewayInfo'])->name('gatewayInfo');
    Route::post('/store', [OrderBalanceController::class, 'store'])->name('store');
    Route::get('/details/{order_id}', [OrderBalanceController::class, 'getOrderDetails'])->name('getOrderDetails');
    
});

// marchant.order.balance.approve.index
Route::group(['prefix' => 'all/order/balance', 'as' => 'approve.'], function () {
    Route::get('/', [OrderBalanceApproveController::class, 'index'])->name('index');
    Route::put('/update-status/{id}', [OrderBalanceApproveController::class, 'updateStatus'])->name('updateStatus');
});