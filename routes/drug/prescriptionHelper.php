<?php

use App\Http\Controllers\Drug\DrugAdviceController;
use App\Http\Controllers\Drug\DrugController;
use App\Http\Controllers\Drug\DrugDosesController;
use App\Http\Controllers\Drug\DrugDurationController;
use App\Http\Controllers\Drug\DrugStrengthController;
use App\Http\Controllers\Drug\SubscriptionController;
use App\Http\Controllers\Drug\SubscriptionTypeController;
use Illuminate\Support\Facades\Route;

// subscription type 
// name route  drug.supscription.type.index
// url /drug/subscription-type
Route::group(['prefix' => 'subscription-type', 'as' => 'type.'], function () {
    Route::get('/', [SubscriptionTypeController::class, 'index'])->name('index');
    Route::post('/store', [SubscriptionTypeController::class,  'store'])->name('store');
    Route::get('/edit/{subscription_type_id}', [SubscriptionTypeController::class,  'edit'])->name('edit');
    Route::put('/update/{subscription_type_id}', [SubscriptionTypeController::class,  'update'])->name('update');
    Route::get('/re-order', [SubscriptionTypeController::class, 'reorder'])->name('reorder');
    Route::post('/re-order/update', [SubscriptionTypeController::class,  'reorderUpdate'])->name('reorder.update');
});

// subscription 
// name route  drug.supscription.index
// url /drug/subscription
Route::group(['prefix' => 'subscription'], function () {
    Route::get('/', [SubscriptionController::class, 'index'])->name('index');
    Route::post('/store', [SubscriptionController::class,  'store'])->name('store');
    Route::get('/edit/{menu_id}', [SubscriptionController::class,  'edit'])->name('edit');
    Route::put('/update/{menu_id}', [SubscriptionController::class,  'update'])->name('update');
});
