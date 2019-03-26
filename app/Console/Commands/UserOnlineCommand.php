<?php

namespace App\Console\Commands;

use Auth;
use Carbon\Carbon;
use App\Traits\UserLoginActivityRecording;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Event;

class UserOnlineCommand extends Command
{
    use UserLoginActivityRecording;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:online';

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
                                  ->where('last_activity_at', '>', Carbon::now()->subMinutes(15))
                                  ->pluck('user_id')
                                  ;

        // $inactiveOnlineUserLastActs = \App\UserLogin::whereNull('logged_out_at')
        //                           ->whereNotNull('last_activity_at')
        //                           ->where('last_activity_at', '>', Carbon::now()->subMinutes(15))
        //                           ->first(['last_activity_at'])
        //                           ;
        // dd(
        //     $inactiveOnlineUserLastActs->last_activity_at > Carbon::now()->subMinutes(15), 
        //     'AcTm: ' . $inactiveOnlineUserIds->last_activity_at, 
        //     'SubT: ' . Carbon::now()->subMinutes(15),
        //     carbon::parse($inactiveOnlineUserIds->last_activity_at)->diffInSeconds(Carbon::now()->subMinutes(15))
        // );
        
        // First passing, mark last activity.
        foreach ($activelyOnlineUserIds as $userId) {
            $user = \App\User::find($userId);

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

        // Track inactivity for 30 minutes and quit.
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

            // # Check the last activity time
            // if (! $user->isOnline() && (\Carbon\Carbon::parse($user->last_activity_at)->addMinutes(15) > \Carbon\Carbon::now()))  {

            //     $this->collectUserLogoutData($userId= $user->id, $minutes= 15);

            //     # Manually log out the user.
            //     Auth::logout();
            //     # Event::fire('auth.logout', [$user]);

            //     // A call to route('auth.logout')
            //     // logoutOtherDevices($password, $attribute = 'password')
            //     // Illuminate\Auth\SessionGuard @logout()
            // }
        }
      // dd($usersOnlineCountLst5Minutes, $activelyOnlineUserIds, $inactiveOnlineUserIds);
    }
}
