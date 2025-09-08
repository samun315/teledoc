<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Frontend\FrontendController;
use App\Http\Controllers\UploadController;
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

Route::post('/store/upload-image', [UploadController::class, 'upload'])->name('ckeditor.upload');

Route::get('/home', [FrontendController::class, 'homePage'])->name('home');
Route::get('/welcome2', [FrontendController::class, 'homePage2'])->name('welcome2');
Route::get('/contact-us', [FrontendController::class, 'contactUs'])->name('contact-us');
Route::get('/about', [FrontendController::class, 'about'])->name('about');
Route::get('/blog', [FrontendController::class, 'blog'])->name('blog');


