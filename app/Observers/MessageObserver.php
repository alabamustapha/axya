<?php

namespace App\Observers;

use App\Message;
use Cache;

class MessageObserver
{
    /** ~~~~~~~~~~ Caching Handling ~~~~~~~~~~ */

    /**
     * Flush the cache
     */
    public function flushCache(Message $message)
    {
        $cachedChatName = 'chat_messages_'. $message->messageable->slug;
        
        Cache::forget($cachedChatName);
    }

    /**
     * Handle the message "created" event.
     *
     * @param  \App\Message  $message
     * @return void
     */
    public function created(Message $message)
    {
        //
        self::flushCache($message);
    }

    /**
     * Handle the message "deleted" event.
     *
     * @param  \App\Message  $message
     * @return void
     */
    public function deleted(Message $message)
    {
        //
        self::flushCache($message);
    }

    /**
     * Handle the message "restored" event.
     *
     * @param  \App\Message  $message
     * @return void
     */
    public function restored(Message $message)
    {
        //
        self::flushCache($message);
    }

    /**
     * Handle the message "force deleted" event.
     *
     * @param  \App\Message  $message
     * @return void
     */
    public function forceDeleted(Message $message)
    {
        //
        self::flushCache($message);
    }
}
