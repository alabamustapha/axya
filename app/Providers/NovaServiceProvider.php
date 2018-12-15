<?php

namespace App\Providers;

use App\Nova\Metrics\UsersCount;
use App\Nova\Metrics\UsersTrend;
use App\Nova\Metrics\UsersGenderPartition;
use Illuminate\Support\Facades\Gate;
use Laravel\Nova\Cards\Help;
use Laravel\Nova\Nova;
use Laravel\Nova\NovaApplicationServiceProvider;
use App\Nova\Metrics\Doctors\DoctorsCount;
use App\Nova\Metrics\Doctors\DoctorsTrend;
use App\Nova\Metrics\Doctors\DoctorsPartition;

class NovaServiceProvider extends NovaApplicationServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }

    /**
     * Register the Nova routes.
     *
     * @return void
     */
    protected function routes()
    {
        Nova::routes()
                ->withAuthenticationRoutes()
                ->withPasswordResetRoutes()
                ->register();
    }

    /**
     * Register the Nova gate.
     *
     * This gate determines who can access Nova in non-local environments.
     *
     * @return void
     */
    protected function gate()
    {
        Gate::define('viewNova', function ($user) {
            return in_array($user->email, [                
              'cucuteanu@yahoo.com',
              'alabamustapha@gmail.com',
              'tonyfrenzy@gmail.com'
            ]);
        });
    }

    /**
     * Get the cards that should be displayed on the Nova dashboard.
     *
     * @return array
     */
    protected function cards()
    {
        return [
            // new Help,
            new UsersCount,
            new UsersTrend,
            new UsersGenderPartition,

            new DoctorsCount,
            new DoctorsTrend,
            new DoctorsPartition,
        ];
    }

    /**
     * Get the tools that should be listed in the Nova sidebar.
     *
     * @return array
     */
    public function tools()
    {
        return [];
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
