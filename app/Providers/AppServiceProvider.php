<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Spatie\Flash\Flash;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::defaultView('vendor.pagination.tabler');

        Flash::levels([
            'success' => 'text-bg-success',
            'info' => 'text-bg-info',
            'warning' => 'text-bg-warning',
            'error' => 'text-bg-danger',
        ]);
    }
}
