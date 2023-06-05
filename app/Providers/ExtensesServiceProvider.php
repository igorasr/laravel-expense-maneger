<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\ExpenseService;

class ExtensesServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(ExpenseService::class, function ($app) {
            return new ExpenseService();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
