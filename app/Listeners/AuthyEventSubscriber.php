<?php

namespace App\Listeners;

use Auth;
use App\Traits\UserLoginActivityRecording;
use Illuminate\Contracts\Queue\ShouldQueue;

class AuthyEventSubscriber //implements ShouldQueue
{
    use UserLoginActivityRecording;

    /**
     * Handle user login events.
     */
    public function onUserLogin($event) 
    {
        Auth::user()->logOutAsAdminOrDoctor();

        $this->collectUserLoginData(); 
    }

    /**
     * Handle user logout events.
     */
    public function onUserLogout($event) 
    {
        Auth::user()->logOutAsAdminOrDoctor();

        $this->collectUserLogoutData(); 
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param  \Illuminate\Events\Dispatcher  $events
     */
    public function subscribe($events)
    {
        $events->listen(
            'Illuminate\Auth\Events\Login',
            'App\Listeners\AuthyEventSubscriber@onUserLogin'
        );

        $events->listen(
            'Illuminate\Auth\Events\Logout',
            'App\Listeners\AuthyEventSubscriber@onUserLogout'
        );
    }
}