<?php

namespace App\Traits;

trait ModelCachingTrait
{
    /**
     * Get all the settings
     *
     * @return mixed
     */
    public static function getAll()
    {
        return Cache::rememberForever('model.all', function() {
            return self::all();
        });
    }

    /**
     * Flush the cache
     */
    public static function flushCache()
    {
        Cache::forget('model.all');
    }

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::updated(function () {
            self::flushCache();
        });

        static::created(function() {
            self::flushCache();
        });
    }

}