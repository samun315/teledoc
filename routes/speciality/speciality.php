<?php

use App\Http\Controllers\Speciality\SpecialityController;
use Illuminate\Support\Facades\Route;

// Speciality routes
// name route  speciality.index
// url /speciality
Route::group([], function () {
    Route::get('/', [SpecialityController::class, 'index'])->name('index');
    Route::get('/create', [SpecialityController::class, 'create'])->name('create');
    Route::post('/store', [SpecialityController::class, 'store'])->name('store');
    Route::get('/edit/{speciality_id}', [SpecialityController::class, 'edit'])->name('edit');
    Route::put('/update/{speciality_id}', [SpecialityController::class, 'update'])->name('update');
    Route::delete('/delete/{speciality_id}', [SpecialityController::class, 'destroy'])->name('delete');
    Route::get('/change-status/{speciality_id}', [SpecialityController::class, 'changeStatus'])->name('changeStatus');
    Route::get('/get-all', [SpecialityController::class, 'getAll'])->name('getAll');
});

