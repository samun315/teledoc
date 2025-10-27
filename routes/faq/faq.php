<?php

use App\Http\Controllers\Faq\FaqController;
use Illuminate\Support\Facades\Route;

// FAQ routes
// name route  faq.index
// url /faq-management
Route::group([], function () {
    Route::get('/', [FaqController::class, 'index'])->name('index');
    Route::get('/create', [FaqController::class, 'create'])->name('create');
    Route::post('/store', [FaqController::class, 'store'])->name('store');
    Route::get('/edit/{faq_id}', [FaqController::class, 'edit'])->name('edit');
    Route::put('/update/{faq_id}', [FaqController::class, 'update'])->name('update');
    Route::delete('/delete/{faq_id}', [FaqController::class, 'destroy'])->name('delete');
    Route::get('/change-status/{faq_id}', [FaqController::class, 'changeStatus'])->name('changeStatus');
    Route::get('/get-all', [FaqController::class, 'getAll'])->name('getAll');
});

