<?php

namespace App\Providers;

use App\Models\User;
use App\View\Composers\FrontendComposer;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //dd("test");
//        Gate::define('hrm.employee.index', function (User $user) {
//            dd($user);
//            return $user->role_id == 2;
//        });

        // Register Frontend Composer for all frontend views
        View::composer([
            'frontend.*',
            'frontend.layout.*'
        ], FrontendComposer::class);
    }
}
