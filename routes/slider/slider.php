<?php

use App\Http\Controllers\Slider\SliderController;
use Illuminate\Support\Facades\Route;

// slider
// name route  slider.slider.index
// url /slider/slider
Route::group(['prefix' => 'slider', 'as' => 'slider.'], function () {
    Route::get('/', [SliderController::class, 'index'])->name('index');
    Route::get('/create', [SliderController::class, 'create'])->name('create');
    Route::post('/store', [SliderController::class, 'store'])->name('store');
    Route::get('/edit/{slider_id}', [SliderController::class, 'edit'])->name('edit');
    Route::put('/update/{slider_id}', [SliderController::class, 'update'])->name('update');
    Route::delete('/delete/{slider_id}', [SliderController::class, 'destroy'])->name('delete');
});

