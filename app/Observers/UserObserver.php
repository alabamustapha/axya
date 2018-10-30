<?php

namespace App\Observers;

use App\Notifications\AccountVerificationNotification;
use App\User;
use Carbon\Carbon;

class UserObserver
{
    /**
     * Handle the user "created" event.
     * Verification token not added with create() because the wrong 
     * previously generated old token gets sent with the notify().
     *
     * @param  \App\User  $user
     * @return void
     */
    public function created(User $user)
    {
        // if(app()->environment(['testing','production'])){        
        //     $when = Carbon::now()->addSeconds(5);
        //     $user->notify((new AccountVerificationNotification($user, $verification_token))->delay($when));
        // }

        $user->notify(new AccountVerificationNotification($user));            
    }

    /**
     * Handle the user "updated" event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function updated(User $user)
    {
        //
    }

    /**
     * Handle the  report "deleting" event.
     *
     * @param  \App\Report  $report
     * @return void
     */
    public function deleting(User $user)
    {
        //
    }

    /**
     * Handle the user "deleted" event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function deleted(User $user)
    {
        //
    }

    /**
     * Handle the user "restored" event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function restored(User $user)
    {
        //
    }

    /**
     * Handle the user "force deleted" event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function forceDeleted(User $user)
    {
        //
    }
}
