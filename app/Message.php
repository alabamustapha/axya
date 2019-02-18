<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Message extends Model
{
    protected $fillable = [
      'user_id','body','messageable_id','messageable_type'
    ];

    protected $with = [
      'messageable', 'user',
    ];

    /**
     * Get all of the owning messageable models.
     */
    public function messageable()
    {
        return $this->morphTo(); /* Appointment::class, Ticket::class */
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function prescription()
    {
        return $this->hasOne(Prescription::class);
    }

    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    public function document()
    {
        return $this->morphOne(Document::class, 'documentable');
    }

    // public function documents()
    // {
    //     return $this->morphMany(Document::class, 'documentable');
    // }

    public function type()
    {
        // 1.
        return (new \ReflectionClass($this->messageable_type))->getShortName();

        /* 2.
            $type_frags = explode('\\', $this->messageable_type);
            $end = end($type_frags);

            return $end;
        */
    }

    public function isAppointmentDoctor()
    {
        return $this->user_id == $this->messageable->doctor_id;
    }

    public function isAppointmentAuthor()
    {
        return $this->user_id == $this->messageable->user_id;
    }
    

    public function owner()
    {
        return auth()->id() == $this->user_id; // $this->messageable->user_id;
    }

    public function appointmentDoctor()
    {
        return auth()->id() == $this->messageable->doctor_id;
    }
    

    public function hasPrescription()
    {
        return starts_with($this->body, 'New Prescription');
    }

    public function displayPrescription()
    {
        if ($this->hasPrescription()){
            $getId = explode(': ', $this->body);
            $id    = intval(end($getId));
            
            return \App\Prescription::find($id);
        }
    }



    /** ~~~~~~~~~~ Caching Handling ~~~~~~~~~~ */

    /**
     * Flush the cache
     */
    public static function flushCache()
    {
        Cache::forget('messages.paginate');
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
