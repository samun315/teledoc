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

            //Start Request whitelist Route
            Route::middleware(['web', 'preventBackHistory', 'user'])
                ->prefix('marchant')
                ->name('marchant.request.')
                ->group(base_path('routes/marchant/whitelist.php'));
            //End Request whitelist Route

            //Start Balance Request Route
            Route::middleware(['web', 'preventBackHistory', 'user'])
                ->prefix('marchant')
                ->name('marchant.balance.request.')
                ->group(base_path('routes/marchant/balanceRequest.php'));
            //End Balance Request Route

            //Start ORDER Route
            Route::middleware(['web', 'preventBackHistory', 'user'])
                ->prefix('marchant')
                ->name('marchant.order.balance.')
                ->group(base_path('routes/marchant/order.php'));
            //End ORDER Route

            //Start Transfer Route
            Route::middleware(['web', 'preventBackHistory', 'user'])
                ->prefix('marchant')
                ->name('marchant.transfer.balance.')
                ->group(base_path('routes/marchant/transfer.php'));
            //End Transfer Route

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
