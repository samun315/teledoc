<?php

use App\Http\Controllers\Drug\DrugController;
use Illuminate\Support\Facades\Route;

// name route  drug.type.index
// url /drug/drug-type
Route::group(['prefix' => 'drug-type', 'as' => 'type.'], function () {
    Route::get('/', [DrugController::class, 'index'])->name('index');
    Route::post('/store', [DrugController::class,  'store'])->name('store');
    Route::get('/edit/{menu_id}', [DrugController::class,  'edit'])->name('edit');
    Route::put('/update/{menu_id}', [DrugController::class,  'update'])->name('update');
   
});