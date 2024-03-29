<?php

namespace App\Providers;

use App\Models\Company;
use App\Services\AccessCheckInterface;
use App\Services\GateAccessService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(
            AccessCheckInterface::class,
            GateAccessService::class,
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $accessCheckService = $this->app->make(AccessCheckInterface::class);
        $accessCheckService->defineAccess();

        View::composer('*', function ($view) {
            if (Auth::check()) {
                $company = Company::where('id',Auth::user()->companyId)->first();
                $view->with('company', $company);
            }
        });
    }
}
