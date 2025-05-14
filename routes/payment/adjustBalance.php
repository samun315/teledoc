<?php

use App\Http\Controllers\Payment\BalanceAdjustController;
use Illuminate\Support\Facades\Route;
// marchant.balance.request.index

Route::group(['prefix' => 'adjust/balance'], function () {
    Route::get('/', [BalanceAdjustController::class, 'index'])->name('index');
    Route::post('/store', [BalanceAdjustController::class, 'store'])->name('store');
    Route::get('/get-account-data/{user_id}', [BalanceAdjustController::class, 'getAccount'])->name('getAccount');
});
