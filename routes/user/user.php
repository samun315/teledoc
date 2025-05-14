<?php

use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;


//User route user.index
Route::get('/index', [UserController::class, 'index'])->name('index');
Route::post('/store',[UserController::class, 'store'])->name('store');
Route::get('/edit/{user_id}',[UserController::class, 'edit'])->name('edit');
Route::put('/update/{user_id}',[UserController::class, 'update'])->name('update');
Route::put('/reset-password/{user_id}',[UserController::class, 'resetPassword'])->name('resetPassword');


// user profile route user.profile.viewProfile

Route::group(['prefix' => 'profile', 'as' => 'profile.'], function () {
    Route::get('/', [UserController::class, 'viewProfile'])->name('viewProfile');
    Route::get('/edit', [UserController::class, 'editProfile'])->name('editProfile');
    Route::put('/update/{user_id}', [UserController::class, 'profileUpdate'])->name('profileUpdate');
    Route::get('/change-password', [UserController::class, 'changePassword'])->name('changePassword');
    Route::post('/update-password', [UserController::class, 'updatePassword'])->name('updatePassword');
});