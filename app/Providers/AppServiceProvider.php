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

            $today = date('Y-m-d');            
            $eventsCount = 
                \App\CalendarEvent::where('user_id', auth()->id())
                    ->where('start', 'like', "%$today%")
                    ->count()
                    ;

            $view->with('events_count', $eventsCount);
            $view->with('applications_count', \App\Application::all()->count());
            // $view->with('transactions_count', \App\Transaction::all()->count());
        });

        view()->composer(['admin.dashboard.users'], function($view){
            $view->with('admins_count', \App\User::whereIn('acl', ['1','5'])->count());
            $view->with('staffs_count', \App\User::whereIn('acl', ['2'])->count());
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
