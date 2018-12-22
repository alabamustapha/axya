<?php

namespace App;

use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use Sluggable;

    protected $dates = ['day','sealed_at'];

    // protected $with = ['doctor'];

    protected $appends = [
        'attendant_doctor','creator','description_preview','link',
        'duration','status_text_color','status_text','schedule_is_past',
        'start_time','end_time',
    ];

    protected $fillable = [
      'status','slug','user_id','doctor_id','day','from','to','patient_info','sealed_at','type','address','phone', // 'rated (0|1)' with Reviews (user_id, dr_id & appmt_id composite key/unique)
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
            $str = str_slug($appointment->day) .'-'. auth()->user()->slug;
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
     * Change a appintment's status.
     * 
     * @return null
     */
    public function activateComplete() 
    {
        // Appointment/Consultation completed successfully.
        $this->status = '1';
        $this->update();
    }

    public function activateAccept() 
    {
        //Confirmed, awaiting fees payment
        $this->status = '2';
        $this->update();
    }

    public function activateReject() 
    {
        // Rejected by doctor
        $this->status = '3';
        $this->update();
    }

    public function activateCancel() 
    {
        // Cancelled by patient
        $this->status = '4';
        $this->update();
    }

    public function activateFeePayment() 
    {
        // Fee paid, awaiting appointment time.
        $this->status = '5';
        $this->update();
    }



    /**
     * Was completed successfully.
     */
    public function scopeUncompleted($query)
    {
        // All uncompleted Appointments.
        return $query->where('status', '!=', '1');
    }

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
    public function scopeRejected($query)
    {
        // Rejected by doctor!
        return $query->where('status', '3');
    }
    public function scopeCancelled($query)
    {
        // Cancelled by patient
        return $query->where('status', '4');
    }
    public function scopeAwaitingAppointmentTime($query)
    {
        // Fee paid, awaiting appointment time.
        return $query->where('status', '5');
    }


    /*<!---------------- Update Doctor Application Status ---------------->*/
    public static $appointmentStatus = array(
        0 => 'Awaiting doctor\'s confirmation',

        1 => 'Success',

        2 => 'Appointment accepted by doctor. Awaits fee payment',

        3 => 'Rejected by doctor!',

        4 => 'Cancelled by patient!',
        
        5 => 'Fee paid, awaiting appointment time.',

        // 6 => '<span class="orange"><i class="fa fa-info-circle"></i>&nbsp; Schedule change suggestion by doctor.',

        // 7 => '<span class="teal"><i class="fa fa-info-circle red"></i>&nbsp; Another doctor recommended',
    );

    public static $appointmentStatusColor = array(
        0 => 'indigo',

        1 => 'teal',

        2 => 'orange',

        3 => 'red',

        4 => 'red',
        
        5 => 'orange',

        // 6 => '<span class="orange"><i class="fa fa-info-circle"></i>&nbsp; Schedule change suggestion by doctor.',

        // 7 => '<span class="teal"><i class="fa fa-info-circle red"></i>&nbsp; Another doctor recommended',
    );

    // If the status code is not in the provided list above return the default '0'.
    public function statusText() 
    {
        $status = ($this->status > (sizeof(self::$appointmentStatus) - 1) || $this->status < 0) 
                    ? (sizeof(self::$appointmentStatus) + 1) // Something fishy.
                    : intval($this->status)
                    ;

        return self::$appointmentStatus[$status];
    }
    public function statusTextColor() 
    {
        $status = ($this->status > (sizeof(self::$appointmentStatusColor) - 1) || $this->status < 0) 
                    ? (sizeof(self::$appointmentStatusColor) + 1) // red
                    : intval($this->status)
                    ;

        return self::$appointmentStatusColor[$status];
    }


    /****** ~ API Candidates ~ ******/

    public function getLinkAttribute()
    {
      return route('appointments.show', $this);
    }    


    #~~ Time/Schedule Related
    #------------------------------------------------#
    public function getDayAttribute($value)
    {
        return Carbon::parse($value)->format('M d, Y');
    }

    // 'From' Time Segment Only
    public function getStartTimeAttribute()
    {
        return Carbon::parse($this->from)->format('h:i A');
    }

    // 'To' Time Segment Only
    public function getEndTimeAttribute()
    {
        return Carbon::parse($this->to)->format('h:i A');
    }

    public function getDurationAttribute()
    {
        $duration  = Carbon::parse($this->end_time)->diffInMinutes(Carbon::parse($this->start_time));
        
        $hour_duration = floor($duration / 60);
        $hour_hand = $hour_duration > 0 ? $hour_duration .' hour' : '';

        $mins_duration = $duration % 60;
        $mins_hand = $mins_duration > 0 ? $mins_duration .' minutes' : '';

        return $hour_hand .' '. $mins_hand;
    }

    // Appointment time and duration is now in the past.
    public function getScheduleIsPastAttribute($value)
    {
        return Carbon::now() > Carbon::parse($this->to);
    }

    public function getPendingYetAttribute()
    {
        return $this->status != '1' && $this->status != '5';
    }


    #~~ Doctor/Patient Related
    #------------------------------------------------#
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
    


    #~~ Status Related
    #------------------------------------------------#
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
