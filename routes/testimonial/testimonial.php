<?php

use App\Http\Controllers\Testimonial\TestimonialController;
use Illuminate\Support\Facades\Route;

// Testimonial routes
// name route  testimonial.index
// url /testimonial
Route::group([], function () {
    Route::get('/', [TestimonialController::class, 'index'])->name('index');
    Route::get('/create', [TestimonialController::class, 'create'])->name('create');
    Route::post('/store', [TestimonialController::class, 'store'])->name('store');
    Route::get('/edit/{testimonial_id}', [TestimonialController::class, 'edit'])->name('edit');
    Route::put('/update/{testimonial_id}', [TestimonialController::class, 'update'])->name('update');
    Route::delete('/delete/{testimonial_id}', [TestimonialController::class, 'destroy'])->name('delete');
    Route::get('/change-status/{testimonial_id}', [TestimonialController::class, 'changeStatus'])->name('changeStatus');
    Route::get('/get-all', [TestimonialController::class, 'getAll'])->name('getAll');
});

