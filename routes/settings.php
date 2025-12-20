<?php

use App\Http\Controllers\Backend\FrontendSettingsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Settings Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->prefix('admin/settings')->name('admin.settings.')->group(function () {

    // Frontend Settings
    Route::prefix('frontend')->name('frontend.')->group(function () {
        // Main page
        Route::get('/', [FrontendSettingsController::class, 'index'])->name('index');

        // Update settings
        Route::post('/general', [FrontendSettingsController::class, 'updateGeneral'])->name('general');
        Route::post('/contact', [FrontendSettingsController::class, 'updateContact'])->name('contact');

        // Social Media CRUD
        Route::get('/social-media', [FrontendSettingsController::class, 'getSocialMedia'])->name('social-media.index');
        Route::post('/social-media', [FrontendSettingsController::class, 'storeSocialMedia'])->name('social-media.store');
        Route::get('/social-media/{id}', [FrontendSettingsController::class, 'getSocialMedia'])->name('social-media.show');
        Route::put('/social-media/{id}', [FrontendSettingsController::class, 'updateSocialMedia'])->name('social-media.update');
        Route::delete('/social-media/{id}', [FrontendSettingsController::class, 'destroySocialMedia'])->name('social-media.destroy');

        // Footer Links CRUD
        Route::get('/footer-links', [FrontendSettingsController::class, 'getFooterLinks'])->name('footer-links.index');
        Route::post('/footer-links', [FrontendSettingsController::class, 'storeFooterLink'])->name('footer-links.store');
        Route::get('/footer-links/{id}', [FrontendSettingsController::class, 'getFooterLinks'])->name('footer-links.show');
        Route::put('/footer-links/{id}', [FrontendSettingsController::class, 'updateFooterLink'])->name('footer-links.update');
        Route::delete('/footer-links/{id}', [FrontendSettingsController::class, 'destroyFooterLink'])->name('footer-links.destroy');

        // Logo Upload
        Route::post('/logo', [FrontendSettingsController::class, 'uploadLogo'])->name('logo');
        Route::post('/logo/delete', [FrontendSettingsController::class, 'deleteLogo'])->name('logo.delete');
    });

    // About Section Settings
    Route::prefix('about')->name('about.')->group(function () {
        Route::get('/', [\App\Http\Controllers\About\AboutController::class, 'index'])->name('index');
        Route::post('/update', [\App\Http\Controllers\About\AboutController::class, 'update'])->name('update');
    });

    // Expertise Section Settings
    Route::prefix('expertise')->name('expertise.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Expertise\ExpertiseController::class, 'index'])->name('index');
        Route::post('/update', [\App\Http\Controllers\Expertise\ExpertiseController::class, 'update'])->name('update');
    });
});

