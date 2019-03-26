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
        $type = request()->is('register') ? 'r':'l';

        return UserLogin::create([
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
            $lastLoginRecord->logged_in_seconds = Carbon::now()->diffInSeconds($lastLoginRecord->created_at);
            $lastLoginRecord->logged_in_minutes = Carbon::now()->diffInMinutes($lastLoginRecord->created_at);
            $lastLoginRecord->logged_in_hours   = Carbon::now()->diffInHours($lastLoginRecord->created_at);

            $lastLoginRecord->last_activity_at  = $lastActivityTime;
            $lastLoginRecord->logged_out_at     = Carbon::now()->subMinutes($minutes);
            $lastLoginRecord->exit_page         = request()->server('HTTP_REFERER');        

            $lastLoginRecord->save();
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

        return;
    }
}