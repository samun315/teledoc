<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Frontend\FrontendController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LoginController::class, 'showLoginForm'])->name('showLoginForm');
//Route::get('login', [LoginController::class, 'showLoginForm'])->name('showLoginForm');
Route::post('login', [LoginController::class, 'login'])->name('login');

Route::get('/module-list', function () {
    return view('moduleList.index');
});

//Private Routes
Route::middleware(['preventBackHistory', 'user'])->group(function () {

    //Logout
    Route::get('logout', [LoginController::class, 'logout'])->name('user.logout');

    //Dashboard Route
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

});

Route::get('/welcome', [FrontendController::class, 'homePage'])->name('welcome');


