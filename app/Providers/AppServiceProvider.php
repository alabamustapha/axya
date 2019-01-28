<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        view()->composer(['layouts.partials.dashboard-sidebar'], function($view){
            $view->with('applications_count', \App\Application::all()->count());
        });

        view()->composer(['layouts.redesign.sidebar'], function($view){
            $view->with('applications_count', \App\Application::all()->count());
            $view->with('dr_appointments_count', \App\Appointment::where('doctor_id', auth()->id())
                                                                 ->whereStatus('0')
                                                                 ->get()->count());
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
