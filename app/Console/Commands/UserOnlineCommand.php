<?php

namespace App\Console\Commands;

use App\Traits\UserLoginActivityRecording;
use App\Traits\collectUserLogoutData;
use Illuminate\Console\Command;

class UserOnlineCommand extends Command
{
    use UserLoginActivityRecording;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:online';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check and update user online activity status';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() // RUN EVERY 5MINUTES..................................................
    {
        // for every logged in users (is_null(logins->))
        $activelyOnlineUserIds = \App\UserLogin::whereNull('logged_out_at')
                                  ->whereNull('last_activity_at')
                                  ->pluck('user_id')
                                  ;
        $usersOnlineCountLst5Minutes 
            = $activelyOnlineUserIds->count(); // Log to a DB Table.

        $inactiveOnlineUserIds = \App\UserLogin::whereNull('logged_out_at')
                                  ->whereNotNull('last_activity_at')
                                  ->pluck('user_id')
                                  ;
        // dd($activelyOnlineUserIds, $usersOnlineCountLst5Minutes, $inactiveOnlineUserIds);
        
        // First passing, mark last activity.
        foreach ($activelyOnlineUserIds as $userId) {
            $user = \App\User::find($userId);
            // dd($user, session()->getId());

            if (! $user->isOnline()) {
                    
                // Just update Last Activity field.
                $lastActivity = 
                    $user->logins()
                            ->where('session_id', session()->getId())
                            ->latest()
                            ->first()
                    ?
                    $user->logins()
                            ->where('session_id', session()->getId())
                            ->latest()
                            ->first()
                            ->update(['last_activity_at'=> now()->subMinutes(2)])
                    // If logged in through registration
                    : $user->logins()
                            ->latest()
                            ->first()
                            ->update(['last_activity_at'=> now()->subMinutes(2)])
                    ;
            }
        }

        // First passing, mark last activity.
        foreach ($inactiveOnlineUserIds as $userId) {
            $user = \App\User::find($userId);

            // Got active again
            if ($user->isOnline()) {
                $user->logins()
                        ->where('session_id', session()->getId())
                        ->latest()
                        ->first()
                ? $user->logins()
                        ->where('session_id', session()->getId())
                        ->latest()
                        ->first()
                        ->update(['last_activity_at'=> null])
                        // If logged in through registration
                : $user->logins()
                        ->latest()
                        ->first()
                        ->update(['last_activity_at'=> null])
                ;
            }

            # check the last activity time
            $lastActivityTime = $user->last_activity_at; ->loginUsingId()
            if (! $user->isOnline() && (\Carbon\Carbon::parse($lastActivityTime)->addMinutes(10) > \Carbon\Carbon::now()))  {

                // # if inactive for 30minutes log out and record -logged_out_at == -30minutes
                $this->collectUserLogoutData($userId= $user->id, $minutes= 10);
            }
        }
    }
}
