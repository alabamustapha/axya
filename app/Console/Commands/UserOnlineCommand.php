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
    public function handle()
    {
        $activelyOnlineUserIds = \App\UserLogin::whereNull('logged_out_at')
                                  ->whereNull('last_activity_at')
                                  ->pluck('user_id')
                                  ;
        $usersOnlineCountLst5Minutes 
            = $activelyOnlineUserIds->count(); // Log to a DB Table.

        $inactiveOnlineUserIds = \App\UserLogin::whereNull('logged_out_at')
                                  ->whereNotNull('last_activity_at')       // Checked for 2 hours.
                                  ->where('last_activity_at', '>', Carbon::now()->subMinutes(120))
                                  ->pluck('user_id')
                                  ;
        
        // First passing: Mark record last activity.
        foreach ($activelyOnlineUserIds as $userId) {
            $user = \App\User::find($userId);

            if (! $user->isOnline()) {
                    
                // Just update Last Activity field.
                $lastActivity = 
                    $user->logins()->where('session_id', session()->getId())->exists()
                    ? $user->logins()
                            ->where('session_id', session()->getId())
                            ->first()
                            ->update([
                              'last_activity_at'=> now()->subMinutes(2)
                            ])
                    // If logged in through registration
                    : $user->logins()
                            ->latest()
                            ->first()
                            ->update([
                              'last_activity_at'=> now()->subMinutes(2)
                            ])
                    ;
            }
        }

        // Second passing: Track inactivity for 2 hours and quit.
        foreach ($inactiveOnlineUserIds as $userId) {
            $user = \App\User::find($userId);

            // Got active again
            if ($user->isOnline()) {
                $user->logins()->where('session_id', session()->getId())->exists()
                ? $user->logins()
                        ->where('session_id', session()->getId())
                        ->first()
                        ->update([
                          'last_activity_at'=> null
                        ])
                        // If logged in through registration
                : $user->logins()
                        ->latest()
                        ->first()
                        ->update([
                          'last_activity_at'=> null
                        ])
                ;
            }

            ## Log out some users.
            if (! $user->isOnline() && (\Carbon\Carbon::parse($user->last_activity_at)->addMinutes(15) > \Carbon\Carbon::now()))  {
                # If user is a doctor/admin log out of session if not active after 15.
                if ($user->isStaff() || $user->is_doctor) {                  
                    // $user->logOutAsAdminOrDoctor();
                    if ($user->isAuthenticatedStaff()) {
                        $user->update(['admin_mode' => 0]);
                    }

                    if ($user->isLoggedInAsDoctor()) {
                        $user->update(['doctor_mode' => 0]);
                    }
                }

                // # Manually log out the user.
                // $this->collectUserLogoutData($userId= $user->id, $minutes= 15);
                // Auth::logout();
                // Event::fire('auth.logout', [$user]);


                // A call to route('auth.logout')
                // logoutOtherDevices($password, $attribute = 'password')
                // Illuminate\Auth\SessionGuard @logout()
            }
        }
        
        $this->info($usersOnlineCountLst5Minutes);
        $this->info($activelyOnlineUserIds);
        $this->info($inactiveOnlineUserIds);
    }
}
