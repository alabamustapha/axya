<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
      'user_id','body','messageable_id','messageable_type'
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

    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function documents()
    {
        return $this->morphMany(Document::class, 'documentable');
    }

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
        return (bool) $this->user_id == $this->messageable->doctor_id;
    }

    public function isAppointmentAuthor()
    {
        return (bool) $this->user_id == $this->messageable->user_id;
    }
}
