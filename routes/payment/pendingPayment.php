<?php

use App\Http\Controllers\Payment\PendingPaymentController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'pending-payments', 'as' => 'pending-payments.'], function () {
    Route::get('/', [PendingPaymentController::class, 'index'])->name('index');
});
