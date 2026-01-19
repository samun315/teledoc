<?php

use App\Http\Controllers\Order\OrderController;
use Illuminate\Support\Facades\Route;

// order
// name route  order.payment
// url /order/payment/{order_id}
Route::get('/payment/{order_id}', [OrderController::class, 'payment'])->name('payment');
Route::get('/get-order-details/{order_id}', [OrderController::class, 'getOrderDetails'])->name('getOrderDetails');
Route::post('/process-payment', [OrderController::class, 'processPayment'])->name('processPayment');
