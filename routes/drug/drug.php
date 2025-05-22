<?php

use App\Http\Controllers\Drug\DrugTypeController;
use App\Http\Controllers\Drug\DrugStrengthController;
use Illuminate\Support\Facades\Route;

// drug type 
// name route  drug.type.index
// url /drug/drug-type
Route::group(['prefix' => 'drug-type', 'as' => 'type.'], function () {
    Route::get('/', [DrugTypeController::class, 'index'])->name('index');
    Route::post('/store', [DrugTypeController::class,  'store'])->name('store');
    Route::get('/edit/{menu_id}', [DrugTypeController::class,  'edit'])->name('edit');
    Route::put('/update/{menu_id}', [DrugTypeController::class,  'update'])->name('update');
});

// drug strength 
// name route  drug.strength.index
// url /drug/drug-strength
Route::group(['prefix' => 'drug-strength', 'as' => 'strength.'], function () {
    Route::get('/', [DrugStrengthController::class, 'index'])->name('index');
    Route::post('/store', [DrugStrengthController::class,  'store'])->name('store');
    Route::get('/edit/{menu_id}', [DrugStrengthController::class,  'edit'])->name('edit');
    Route::put('/update/{menu_id}', [DrugStrengthController::class,  'update'])->name('update');
});
