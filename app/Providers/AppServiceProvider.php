<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

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
        // Global Database Connection Check
        try {
            DB::connection()->getPdo();
            $db_connected = true;
        } catch (\Exception $e) {
            $db_connected = false;
        }
        View::share('db_connected', $db_connected);
    }
}
