<?php

namespace App;

use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use Sluggable;

    protected $dates = ['day','sealed_at'];

    protected $fillable = [
      'status','slug','user_id','doctor_id','day','from','to','patient_info','sealed_at','type','address','phone'
    ];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source'    => ['day', 'user.slug'],
                'maxLength' => 50,
            ]
        ];
    }

    public function messages()
    {
        return $this->morphMany(Message::class, 'messageable');
    }

    /**
     * Route key
     * 
     * @return string
     */
    public function getRouteKeyName(){
        return 'slug';
    }

    public function documents()
    {
        return $this->morphMany(Document::class, 'documentable');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    /**
     * Was completed successfully.
     */
    public function scopeAwaitingConfirmation($query)
    {
        // New appointment, awaiting doctor's confirmation.
        return $query->where('status', '0');
    }
    public function scopeCompleted($query)
    {
        // Appointment/Consultation completed successfully.
        return $query->where('status', '1');
    }
    public function scopeConfirmed($query)
    {
        // Confirmed, awaiting fees payment
        return $query->where('status', '2');
    }
    public function scopeScheduleChangeSuggestion($query)
    {
        // Schedule change suggestion by doctor
        return $query->where('status', '3');
    }
    public function scopeRejected($query)
    {
        // Rejected by doctor!
        return $query->where('status', '4');
    }
    public function scopeOtherDoctorRecommendation($query)
    {
        // Another doctor recommended.
        return $query->where('status', '5');
    }
    public function scopeCancelled($query)
    {
        // Cancelled by patient
        return $query->where('status', '6');
    }
    public function scopeUncompleted($query)
    {
        // All uncompleted Appointments.
        return $query->where('status', '!=', '1');
    }

    public function scopeAwaitingAppointmentTime($query)
    {
        // Confirmed, payment made, awaiting appointment time.
        return $query->where('status', '7');
    }


    /*<!---------------- Update Doctor Application Status ---------------->*/
    public static $appointmentStatus = array(
        0 => '<span class="indigo"><i class="fa fa-info-circle"></i>&nbsp; Awaiting doctor\'s confirmation</span>',

        1 => '<span class="teal"><i class="fa fa-info-circle teal"></i>&nbsp; Success</span>',

        2 => 'Confirmed, awaiting fees payment',

        3 => '<span class="orange"><i class="fa fa-info-circle"></i>&nbsp; Schedule change suggestion by doctor.</span>',

        4 => '<span class="red"><i class="fa fa-info-circle"></i>&nbsp; Rejected by doctor!</span>',

        5 => '<span class="teal"><i class="fa fa-info-circle red"></i>&nbsp; Another doctor recommended</span>',

        6 => '<span class="red"><i class="fa fa-info-circle red"></i>&nbsp; Cancelled</span>',
        
        7 => '<span class="teal"><i class="fa fa-info-circle teal"></i>&nbsp; Confirmed, awaiting appointment time.</span>',

        8 => '<span class="red"><i class="fa fa-info-circle red"></i>&nbsp; Something fishy</span>'
    );

    // If the status code is not in the provided list above return the default '0'.
    public function statusText() 
    {
        $status = ($this->status > (sizeof(self::$appointmentStatus) - 1) || $this->status < 0) 
                    ? (sizeof(self::$appointmentStatus) + 1) // 8
                    : intval($this->status)
                    ;

        echo self::$appointmentStatus[$status];
    }

    public function getDayAttribute($value)
    {
        return Carbon::parse($value)->format('M d, Y');
    }
}
