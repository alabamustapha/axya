<?php

namespace App;

use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use Sluggable;

    protected $dates = ['day','sealed_at'];

    protected $appends = ['attendant_doctor','creator','description_preview','link','duration','status_text_color','status_text'];

    protected $fillable = [
      'status','slug','user_id','doctor_id','day','from','to','patient_info','sealed_at','type','address','phone',
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

    public static function boot()
    {
        parent::boot();

        static::creating(function ($appointment) {
            $appointment->user_id = auth()->id();
            $str = str_slug($this->day) . auth()->user()->slug;
            $appointment->slug = substr($str, 0, 50);
        });
    }

    public function documents()
    {
        return $this->morphMany(Document::class, 'documentable');
    }

    public function prescriptions()
    {
        return $this->hasMany(Prescription::class);
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
        0 => 'Awaiting doctor\'s confirmation',

        1 => 'Success',

        2 => 'Confirmed, awaiting fees payment',

        3 => 'Rejected by doctor!',

        4 => 'Cancelled by patient!',
        
        5 => 'Confirmed, awaiting appointment time.',

        6 => 'Something fishy',

        // 7 => '<span class="orange"><i class="fa fa-info-circle"></i>&nbsp; Schedule change suggestion by doctor.',

        // 8 => '<span class="teal"><i class="fa fa-info-circle red"></i>&nbsp; Another doctor recommended',
    );

    public static $appointmentStatusColor = array(
        0 => 'indigo',

        1 => 'teal',

        2 => 'orange',

        3 => 'red',

        4 => 'red',
        
        5 => 'orange',

        6 => 'red',

        // 7 => '<span class="orange"><i class="fa fa-info-circle"></i>&nbsp; Schedule change suggestion by doctor.',

        // 8 => '<span class="teal"><i class="fa fa-info-circle red"></i>&nbsp; Another doctor recommended',
    );

    // If the status code is not in the provided list above return the default '0'.
    public function statusText() 
    {
        $status = ($this->status > (sizeof(self::$appointmentStatus) - 1) || $this->status < 0) 
                    ? (sizeof(self::$appointmentStatus) + 1) // 8
                    : intval($this->status)
                    ;

        return self::$appointmentStatus[$status];
    }
    public function statusTextColor() 
    {
        $status = ($this->status > (sizeof(self::$appointmentStatusColor) - 1) || $this->status < 0) 
                    ? (sizeof(self::$appointmentStatusColor) + 1) // 8
                    : intval($this->status)
                    ;

        return self::$appointmentStatusColor[$status];
    }


    /**** ~API Candidates~****/

    public function getLinkAttribute()
    {
      return route('appointments.show', $this);
    }

    public function getDayAttribute($value)
    {
        return Carbon::parse($value)->format('M d, Y');
    }

    public function getFromAttribute($value)
    {
        return Carbon::parse($value)->format('h:i A');
    }

    public function getToAttribute($value)
    {
        return Carbon::parse($value)->format('h:i A');
    }

    public function getDurationAttribute($value)
    {
        return Carbon::parse($this->to)->diffInMinutes(Carbon::parse($this->from));
    }

    public function getAttendantDoctorAttribute()
    {
        return intval(auth()->id()) === intval($this->doctor_id);
    }

    public function attendantDoctor()
    {
        return intval(auth()->id()) === intval($this->doctor_id);
    }

    public function getCreatorAttribute()
    {
        return intval(auth()->id()) === intval($this->user_id);
    }

    public function getDescriptionPreviewAttribute()
    {
      $descr_preview = substr($this->patient_info, 0, 100);
      
      return strlen($this->patient_info) > 100 ? $descr_preview .'...':$this->patient_info;
    }

    public function getStatusTextAttribute()
    {
      return strval($this->statusText());
    }

    public function getStatusTextColorAttribute()
    {
      return strval($this->statusTextColor());
    }

    public function statusTextOutput()
    {        
      /*# Throw this into components that cannot accept string format below
        <span class="{{$appointment->status_text_color}} text-bold">
            <i class="fa fa-info-circle"></i>&nbsp;
            {{$appointment->status_text}}
        </span>
      */
      $str  = '<span class="'. $this->status_text_color .' text-bold">';
      $str .= '<i class="fa fa-info-circle"></i>&nbsp;';
      $str .= $this->status_text;
      $str .= '</span>';

      echo $str;
    }
}
