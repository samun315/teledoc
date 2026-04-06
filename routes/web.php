<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Frontend\FrontendController;
use App\Http\Controllers\UploadController;
use Illuminate\Support\Facades\Route;

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('showLoginForm');
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

Route::post('/store/upload-image', [UploadController::class, 'upload'])->name('admin.summernote.uploadImage');

Route::get('/', [FrontendController::class, 'homePage'])->name('home');
Route::get('/welcome2', [FrontendController::class, 'homePage2'])->name('welcome2');
Route::get('/contact-us', [FrontendController::class, 'contactUs'])->name('contact-us');
Route::get('/about', [FrontendController::class, 'about'])->name('about');
Route::get('/blog', [FrontendController::class, 'blog'])->name('blog');
Route::get('/blog-details/{slug}', [FrontendController::class, 'blogDetails'])->name('blog-details');
Route::get('/service', [FrontendController::class, 'service'])->name('service');
Route::get('/service-details/{id}', [FrontendController::class, 'serviceDetails'])->name('service-details');
Route::get('/faqs', [FrontendController::class, 'faqs'])->name('faqs');
Route::get('/doctors', [FrontendController::class, 'doctors'])->name('doctors');
Route::get('/doctor-details/{id}', [FrontendController::class, 'doctorDetails'])->name('doctor-details');
Route::get('/terms-conditions', [FrontendController::class, 'termsConditions'])->name('termsConditions');
Route::get('/privacy-policy', [FrontendController::class, 'privacyPolicy'])->name('privacyPolicy');
Route::get('/payment-instructions', [FrontendController::class, 'paymentInstructions'])->name('payment.instructions');

// Patient Registration Routes
Route::get('/patient/register', [FrontendController::class, 'showRegistrationForm'])->name('patient.register');
Route::post('/patient/register', [FrontendController::class, 'registerPatient'])->name('patient.register.store');

// Appointment Booking Routes
Route::get('/patient/appointment', [FrontendController::class, 'appointment'])->name('patient.appointment');
Route::get('/appointment/get-doctors', [FrontendController::class, 'getDoctors'])->name('appointment.get-doctors');
Route::get('/appointment/get-available-slots/{doctorId}/{date}', [FrontendController::class, 'getAvailableSlots'])->name('appointment.get-available-slots');
Route::post('/patient/appointment/store', [FrontendController::class, 'storeAppointment'])->name('patient.appointment.store');

// Feedback Routes
Route::post('/feedback/store', [FrontendController::class, 'storeFeedback'])->name('feedback.store');

// Include Settings Routes
require __DIR__.'/settings.php';

