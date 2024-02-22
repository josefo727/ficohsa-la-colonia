<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use App\Models\Transaction;
use App\Observers\TransactionObserver;

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
        if($this->app->environment('production')) {
            \URL::forceScheme('https');
        }

        Paginator::useBootstrapFive();

        Transaction::observe(TransactionObserver::class);
    }

}
