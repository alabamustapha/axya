<?php

namespace App\Traits;

use Auth;
use App\User;
use App\UserLogin;
use Carbon\Carbon;

trait UserLoginActivityRecording
{
    public function deviceType()
    {
        return $this->osType = \Browser::platformName() .' | '. \Browser::platformFamily() .' | '. \Browser::platformVersion();
    }

    public function osType()
    {
        return \Browser::platformName() .' | '. \Browser::platformFamily() .' | '. \Browser::platformVersion();
    }

    public function collectUserLoginData() 
    {
        // Last activity time is handled by Cron Schedule and is almost certain to be set.
        // If user didn't explicitly log out, last activity time is taken to be an approximate logged out time.
        // This guestimate is closer to the actual time since check is done every 5 minutes.
        $unhandledLogout = 
            Auth::user()->logins()
               ->where('session_id', '!=', session()->getId())
               ->whereNull('logged_out_at')
               ->whereNull('logged_in_seconds')
               ->first();
        if ($unhandledLogout) {
            $unhandledLogout->update([
                'logged_in_seconds' => Carbon::parse($unhandledLogout->last_activity_at)->diffInSeconds($unhandledLogout->created_at),
                'logged_in_minutes' => Carbon::parse($unhandledLogout->last_activity_at)->diffInMinutes($unhandledLogout->created_at),
                'logged_in_hours'   => Carbon::parse($unhandledLogout->last_activity_at)->diffInHours($unhandledLogout->created_at),

                'exit_page'         => config('app.url'),
                'logged_out_at'     => $unhandledLogout->last_activity_at,
            ]);

            // $unhandledLogout->logged_in_seconds = Carbon::parse($unhandledLogout->last_activity_at)->diffInSeconds($unhandledLogout->created_at);
            // $unhandledLogout->logged_in_minutes = Carbon::parse($unhandledLogout->last_activity_at)->diffInMinutes($unhandledLogout->created_at);
            // $unhandledLogout->logged_in_hours   = Carbon::parse($unhandledLogout->last_activity_at)->diffInHours($unhandledLogout->created_at);

            // $unhandledLogout->logged_out_at     = $unhandledLogout->last_activity_at;
            // $unhandledLogout->exit_page         = config('app.url');        
            // $unhandledLogout->save();
        }

        $type = request()->is('register') ? 'r':'l';

        UserLogin::create([
            'user_id'     => auth()->id(),
            'ip'          => request()->ip(),
            'device'      => $this->deviceType(),
            'os'          => $this->osType(),
            'agent'       => $this->detectAgentType(),
            'type'        => $type,
            'logged_in_at'=> Carbon::now(),
            'browser'     => request()->server('HTTP_USER_AGENT'),//->header('User-Agent')
            'referer_page'=> url()->previous(), //or request()->server('HTTP_REFERER'),
            'session_id'  => session()->getId(),
        ]); 
        
        return;
    }

    public function detectAgentType() 
    {
        if     (\Browser::isMobile()) {return 'Mobile';}
        elseif (\Browser::isTablet()) {return 'Tablet';}
        elseif (\Browser::isDesktop()) {return 'Desktop';}
        elseif (\Browser::isBot()) {return 'Bot';}
    }

    public function collectUserLogoutData($userId = null, $minutes = 0)
    {
        $user = User::find($userId) ?: auth()->user();

        $lastLoginRecord = 
            $user->logins()
                        ->where('session_id', session()->getId())
                        ->latest()
                        ->first()
                // If logged in through registration
                ?: $user->logins()
                        ->latest()
                        ->first()
                ;

        $lastActivityTime = $lastLoginRecord->last_activity_at ?: Carbon::now();

        if ($lastLoginRecord) {
            $lastLoginRecord->update([
                'logged_in_seconds' => Carbon::parse($lastLoginRecord->last_activity_at)->diffInSeconds($lastLoginRecord->created_at),
                'logged_in_minutes' => Carbon::parse($lastLoginRecord->last_activity_at)->diffInMinutes($lastLoginRecord->created_at),
                'logged_in_hours'   => Carbon::parse($lastLoginRecord->last_activity_at)->diffInHours($lastLoginRecord->created_at),

                'exit_page'         => config('app.url'),
                'logged_out_at'     => $lastLoginRecord->last_activity_at,
            ]);
            // $lastLoginRecord->logged_in_seconds = Carbon::now()->diffInSeconds($lastLoginRecord->created_at);
            // $lastLoginRecord->logged_in_minutes = Carbon::now()->diffInMinutes($lastLoginRecord->created_at);
            // $lastLoginRecord->logged_in_hours   = Carbon::now()->diffInHours($lastLoginRecord->created_at);

            // $lastLoginRecord->last_activity_at  = $lastActivityTime;
            // $lastLoginRecord->logged_out_at     = Carbon::now()->subMinutes($minutes);
            // $lastLoginRecord->exit_page         = request()->server('HTTP_REFERER');        

            // $lastLoginRecord->save();
        }
        else {
            UserLogin::create([
                'user_id'     => $user->id,
                'ip'          => request()->ip(),
                'device'      => $this->deviceType(),
                'os'          => $this->osType(),
                'agent'       => $this->detectAgentType(),
                'type'        => 'n',
                'browser'     => request()->server('HTTP_USER_AGENT'),
                'session_id'  => session()->getId(),
                'last_activity_at' => $lastActivityTime,  
                'logged_out_at'    => Carbon::now()->subMinutes($minutes),  
                'exit_page'        => url()->previous(),      

            ]);
        }        

        // $user->logOutAsAdminOrDoctor();

        return;
    }
}