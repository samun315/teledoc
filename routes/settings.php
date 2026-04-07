<?php

use App\Http\Controllers\Backend\FrontendSettingsController;
use App\Http\Controllers\Backend\PaymentInstructionsSettingsController;
use App\Http\Controllers\Backend\PaymentModeController;
use App\Http\Controllers\Backend\PaymentTermItemController;
use App\Http\Controllers\Backend\PaymentQuickSummaryItemController;
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

    // Payment instructions page (tabs: hero, modes, terms, summary — public /payment-instructions)
    Route::prefix('payment-instructions')->name('payment-instructions.')->group(function () {
        Route::get('/', [PaymentInstructionsSettingsController::class, 'index'])->name('index');
    });

    // Payment modes (CRUD — listed under Payment instructions → Payment modes tab)
    Route::prefix('payment-modes')->name('payment-modes.')->group(function () {
        Route::post('/', [PaymentModeController::class, 'store'])->name('store');
        Route::get('/{paymentMode}', [PaymentModeController::class, 'show'])->name('show');
        Route::post('/{paymentMode}/update', [PaymentModeController::class, 'update'])->name('update');
        Route::delete('/{paymentMode}', [PaymentModeController::class, 'destroy'])->name('destroy');
    });

    // Payment term items (Terms & Conditions accordion — title, description, icon)
    Route::prefix('payment-term-items')->name('payment-term-items.')->group(function () {
        Route::post('/', [PaymentTermItemController::class, 'store'])->name('store');
        Route::get('/{payment_term_item}', [PaymentTermItemController::class, 'show'])->name('show');
        Route::post('/{payment_term_item}/update', [PaymentTermItemController::class, 'update'])->name('update');
        Route::delete('/{payment_term_item}', [PaymentTermItemController::class, 'destroy'])->name('destroy');
    });

    // Quick summary lines (numbered list under Terms & Conditions)
    Route::prefix('payment-quick-summary-items')->name('payment-quick-summary-items.')->group(function () {
        Route::post('/', [PaymentQuickSummaryItemController::class, 'store'])->name('store');
        Route::get('/{payment_quick_summary_item}', [PaymentQuickSummaryItemController::class, 'show'])->name('show');
        Route::post('/{payment_quick_summary_item}/update', [PaymentQuickSummaryItemController::class, 'update'])->name('update');
        Route::delete('/{payment_quick_summary_item}', [PaymentQuickSummaryItemController::class, 'destroy'])->name('destroy');
    });

    // Legacy URL: redirects to tabbed payment-instructions settings
    Route::prefix('payment-instruction-hero')->name('payment-instruction-hero.')->group(function () {
        Route::get('/', [\App\Http\Controllers\PaymentInstructionHero\PaymentInstructionHeroController::class, 'index'])->name('index');
        Route::post('/update', [\App\Http\Controllers\PaymentInstructionHero\PaymentInstructionHeroController::class, 'update'])->name('update');
    });

    // Privacy Policy Settings
    Route::prefix('privacy-policy')->name('privacy-policy.')->group(function () {
        Route::get('/', [\App\Http\Controllers\PrivacyPolicy\PrivacyPolicyController::class, 'index'])->name('index');
        Route::post('/update', [\App\Http\Controllers\PrivacyPolicy\PrivacyPolicyController::class, 'update'])->name('update');
    });

    // Terms & Conditions Settings
    Route::prefix('terms-conditions')->name('terms-conditions.')->group(function () {
        Route::get('/', [\App\Http\Controllers\TermsConditions\TermsConditionsController::class, 'index'])->name('index');
        Route::post('/update', [\App\Http\Controllers\TermsConditions\TermsConditionsController::class, 'update'])->name('update');
    });

    // Expertise Section Settings
    Route::prefix('expertise')->name('expertise.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Expertise\ExpertiseController::class, 'index'])->name('index');
        Route::post('/update', [\App\Http\Controllers\Expertise\ExpertiseController::class, 'update'])->name('update');
    });
});

