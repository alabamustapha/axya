<?php

namespace App;

use Illuminate\Notifications\DatabaseNotification;

/**
 * @see https://laracasts.com/discuss/channels/laravel/extend-the-database-notification-model
 */
class Notification extends DatabaseNotification
{    
    public function isRead()
    {
        return !! $this->read_at;
    }

    public function icon()
    {
        $message = $this->type;

        $icon = null;
        
        if (str_contains(strtolower($message), 'appointment')) {
            $icon = 'calendar-alt'; // 'appointment'
        }        
        if (str_contains(strtolower($message), 'transaction')) {
            $icon = 'handshake'; //transaction
        }        
        if (str_contains(strtolower($message), 'password')) {
            $icon = 'key'; //password
        }
        if (str_contains(strtolower($message), 'subscription')) {
            $icon = 'rss'; //subscription
        }
        if (str_contains(strtolower($message), 'verification')) {
            $icon = 'user-check'; //verification
        }
        if (str_contains(strtolower($message), 'application')) {
            $icon = 'user-tag'; //application
        }
        if (str_contains(strtolower($message), 'prescription')) {
            $icon = 'prescription'; //prescription
        }
        if (str_contains(strtolower($message), 'sendadmin')) {
            $icon = 'bullhorn'; //adminnotification
        }

        return $icon;
    }
}