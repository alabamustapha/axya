<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\SoftDeletes;

class Message extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
      'user_id','body','messageable_id','messageable_type'
    ];

    protected $with = [
      'messageable', 'user',
    ];

    protected $dates = ['deleted_at'];

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
    


    /**
     * This section is used for proper notification for prescriptions.
     * Prescriptions are linked to a particular message.
     * The need for getLinkAttribute.
     */

    // Normal list for Doctors and Patients
    // Necessitated because of slug diff an thus navigation bugs.
    public function getListAttribute()
    {
        if ($this->messageable_type == 'App\Appointment') {
            if (auth()->id() == $this->messageable->doctor_id) {
                return route('messages.index', [$this->messageable->doctor->user, $this->messageable]);
            }
            
            if (auth()->id() == $this->messageable->user_id) {
                return route('messages.index', [$this->messageable->user, $this->messageable]);
            }
        }
    }

    // Situations where alternate list for Doctors and Patients are needed
    // eg during presocriptin notifications for proper linking for each entity.
    public function getAlternateListAttribute()
    {
        if ($this->messageable_type == 'App\Appointment') {
            if (auth()->id() == $this->messageable->doctor_id) {
                return route('messages.index', [$this->messageable->user, $this->messageable]);
            }

            if (auth()->id() == $this->messageable->user_id) {
                return route('messages.index', [$this->messageable->doctor->user, $this->messageable]);
            }
        }
    }

    // Messages are only linked by their anchor ID attr, no individual page.
    public function getLinkAttribute()
    {
      return $this->list .'#_'. md5($this->id);
    }

    public function getAlternateLinkAttribute()
    {
      return $this->alternate_list .'#_'. md5($this->id);
    }

    public function canBeDeleted()
    {
      return (auth()->id() == $this->user_id) && ($this->created_at->addMinutes(45) > Carbon::now());
    }

}
