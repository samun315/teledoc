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

// drug advice 
// name route  drug.advice.index
// url /drug/drug-advice
Route::group(['prefix' => 'drug-advice', 'as' => 'advice.'], function () {
    Route::get('/', [DrugAdviceController::class, 'index'])->name('index');
    Route::post('/store', [DrugAdviceController::class,  'store'])->name('store');
    Route::get('/edit/{menu_id}', [DrugAdviceController::class,  'edit'])->name('edit');
    Route::put('/update/{menu_id}', [DrugAdviceController::class,  'update'])->name('update');
});

// drug duration 
// name route  drug.duration.index
// url /drug/drug-duration
Route::group(['prefix' => 'drug-duration', 'as' => 'duration.'], function () {
    Route::get('/', [DrugDurationController::class, 'index'])->name('index');
    Route::post('/store', [DrugDurationController::class,  'store'])->name('store');
    Route::get('/edit/{menu_id}', [DrugDurationController::class,  'edit'])->name('edit');
    Route::put('/update/{menu_id}', [DrugDurationController::class,  'update'])->name('update');
});

// drug dose 
// name route  drug.doses.index
// url /drug/drug-doses
Route::group(['prefix' => 'drug-doses', 'as' => 'doses.'], function () {
    Route::get('/', [DrugDosesController::class, 'index'])->name('index');
    Route::post('/store', [DrugDosesController::class,  'store'])->name('store');
    Route::get('/edit/{menu_id}', [DrugDosesController::class,  'edit'])->name('edit');
    Route::put('/update/{menu_id}', [DrugDosesController::class,  'update'])->name('update');
});

// drug 
// name route  drug.index
// url /drug
Route::get('/', [DrugController::class, 'index'])->name('index');
Route::post('/store', [DrugController::class,  'store'])->name('store');
Route::get('/edit/{menu_id}', [DrugController::class,  'edit'])->name('edit');
Route::put('/update/{menu_id}', [DrugController::class,  'update'])->name('update');
