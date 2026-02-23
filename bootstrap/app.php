<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
        then: function () {

            //User Route
            Route::middleware(['web', 'preventBackHistory', 'user'])
                ->prefix('users')
                ->name('user.')
                ->group(base_path('routes/user/user.php'));
            //End User Route

            //Common master Route
            Route::middleware(['web', 'preventBackHistory', 'user'])
                ->prefix('common')
                ->name('common.master.')
                ->group(base_path('routes/common/master.php'));
            //End Sales Common master Route

            //Menu master Route
            Route::middleware(['web', 'preventBackHistory', 'user'])
                ->prefix('menu')
                ->name('menu.master.')
                ->group(base_path('routes/menu/master.php'));
            //End Sales Menu master Route

            //Start Menu Menu-item Route
            Route::middleware(['web', 'preventBackHistory', 'user'])
                ->prefix('menu')
                ->name('menu.')
                ->group(base_path('routes/menu/menu.php'));
            //End Menu Menu-item Route

            //Start Request drugs Route
            Route::middleware(['web', 'preventBackHistory', 'user'])
                ->prefix('drug')
                ->name('drug.')
                ->group(base_path('routes/drug/drug.php'));
            //End Request drugs Route

            //Start Request prescription helper subscription Route
            Route::middleware(['web', 'preventBackHistory', 'user'])
                ->prefix('drug')
                ->name('drug.subscription.')
                ->group(base_path('routes/drug/prescriptionHelper.php'));
            //End Request prescription helper subscription Route

            //Start Request prescription Route
            Route::middleware(['web', 'preventBackHistory', 'user'])
                ->prefix('drug')
                ->name('drug.prescription.')
                ->group(base_path('routes/drug/prescription.php'));
            //End Request prescription Route

            //Start Patient Route
            Route::middleware(['web', 'preventBackHistory', 'user'])
                ->prefix('patient')
                ->name('patient.')
                ->group(base_path('routes/patient/patient.php'));
            //End Patient Route

            //Start doctor Route
            Route::middleware(['web', 'preventBackHistory', 'user'])
                ->prefix('doctor')
                ->name('doctor.')
                ->group(base_path('routes/doctor/doctor.php'));
            //End doctor Route

            //Start Schedule Route
            Route::middleware(['web', 'preventBackHistory', 'user'])
                ->prefix('schedule')
                ->name('schedule.')
                ->group(base_path('routes/doctor/schedule.php'));
            //End Schedule Route

            //Start Appointment Route
            Route::middleware(['web', 'preventBackHistory', 'user'])
                ->prefix('appointment')
                ->name('appointment.')
                ->group(base_path('routes/doctor/appointment.php'));
            //End Appointment Route

            //Start Order Route
            Route::middleware(['web', 'preventBackHistory', 'user'])
                ->prefix('order')
                ->name('order.')
                ->group(base_path('routes/order/order.php'));
            //End Order Route

            //Start Payment Gateway Route
            Route::middleware(['web', 'preventBackHistory', 'user'])
                ->prefix('payment')
                ->name('payment.manual.')
                ->group(base_path('routes/payment/paymentGateway.php'));
            //End Payment Gateway Route

            //Start Balance adjust Route
            Route::middleware(['web', 'preventBackHistory', 'user'])
                ->prefix('payment')
                ->name('payment.adjust.balance.')
                ->group(base_path('routes/payment/adjustBalance.php'));
            //End Balance adjust Route

            //Start Pending Payment Route
            Route::middleware(['web', 'preventBackHistory', 'user'])
                ->prefix('payment')
                ->name('payment.')
                ->group(base_path('routes/payment/pendingPayment.php'));
            //End Pending Payment Route

            //Start Blog Route
            Route::middleware(['web', 'preventBackHistory', 'user'])
                ->prefix('blog')
                ->name('blog.')
                ->group(base_path('routes/blog/blog.php'));
            //End blog Route

            //Start Slider Route
            Route::middleware(['web', 'preventBackHistory', 'user'])
                ->prefix('slider')
                ->name('slider.')
                ->group(base_path('routes/slider/slider.php'));
            //End Slider Route

            //Start Service Route
            Route::middleware(['web', 'preventBackHistory', 'user'])
                ->prefix('service')
                ->name('service.')
                ->group(base_path('routes/service/service.php'));
            //End Service Route

            //Start Speciality Route
            Route::middleware(['web', 'preventBackHistory', 'user'])
                ->prefix('speciality')
                ->name('speciality.')
                ->group(base_path('routes/speciality/speciality.php'));
            //End Speciality Route

            //Start Testimonial Route
            Route::middleware(['web', 'preventBackHistory', 'user'])
                ->prefix('testimonial')
                ->name('testimonial.')
                ->group(base_path('routes/testimonial/testimonial.php'));
            //End Testimonial Route

            //Start FAQ Route
            Route::middleware(['web', 'preventBackHistory', 'user'])
                ->prefix('faq-management')
                ->name('faq.')
                ->group(base_path('routes/faq/faq.php'));
            //End FAQ Route

            //Start Feedback Route
            Route::middleware(['web', 'preventBackHistory', 'user'])
                ->prefix('feedback-management')
                ->name('feedback.')
                ->group(base_path('routes/feedback/feedback.php'));
            //End Feedback Route

            //****Start Api Route******//
            Route::middleware(['api'])
                ->prefix('api')
                ->name('api.')
                ->group(base_path('routes/api/api.php'));
            //****Start Api Route******//
        },
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'user' => \App\Http\Middleware\UserAuth::class,
            'preventBackHistory' => \App\Http\Middleware\PreventBackHistory::class,
        ])->web(append: [
            \App\Http\Middleware\GenerateCSPNonce::class,
            \App\Http\Middleware\AuthGates::class
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
