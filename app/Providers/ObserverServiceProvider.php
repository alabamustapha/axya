<?php

namespace App\Providers;

use App\Application;
use App\Message;
use App\Observers\ApplicationObserver;
use App\Observers\MessageObserver;
use App\Observers\UserObserver;
use App\User;
use Illuminate\Support\ServiceProvider;

class ObserverServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        User::observe(UserObserver::class);
        Application::observe(ApplicationObserver::class);
        Message::observe(MessageObserver::class);
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
