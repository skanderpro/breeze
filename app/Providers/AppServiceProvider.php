<?php

namespace App\Providers;
use View;
use App\User;
use App\Company;
use Auth;
use DB;

use Illuminate\Support\ServiceProvider;

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

      View::composer('*', function ($view) {
        if (Auth::check()) {
          $company = Company::where('id',Auth::user()->companyId)->first();
          $view->with('company', $company);
        }
      });

    }
}
