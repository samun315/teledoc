<?php

use App\Http\Controllers\Feedback\FeedbackController;
use Illuminate\Support\Facades\Route;

// Feedback routes for admin
// name route  feedback.index
// url /feedback-management
Route::group([], function () {
    Route::get('/', [FeedbackController::class, 'index'])->name('index');
    Route::get('/view/{feedback_id}', [FeedbackController::class, 'show'])->name('show');
    Route::post('/update-status/{feedback_id}', [FeedbackController::class, 'updateStatus'])->name('updateStatus');
    Route::get('/get-data', [FeedbackController::class, 'getDataTable'])->name('getData');
});
