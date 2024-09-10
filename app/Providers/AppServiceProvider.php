<?php

namespace App\Providers;

use App\Interfaces\AuthServiceInterface;
use App\Interfaces\CurrencyServiceInterface;
use App\Interfaces\IncomeServiceInterface;
use App\Services\AuthService;
use App\Services\CurrencyService;
use App\Services\IncomeService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void {
        app()->bind(AuthServiceInterface::class, function($app) {
            return new AuthService();
        });
        
        app()->bind(IncomeServiceInterface::class, function($app) {
            return new IncomeService();
        });

        app()->bind(CurrencyServiceInterface::class, function($app) {
            return new CurrencyService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void {
        //
    }
}
