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
        'schedule','duration','start_time','end_time','fee','no_of_sessions',
        'status_text_color','status_text',
        'schedule_is_past','within_booking_time_limit'
    ];

    protected $fillable = [
      'slug','user_id','doctor_id','description',
      'illness_duration','illness_history',
      'day','from','to','sealed_at',
      'status','type','address','phone',
      'rating','reviewed',// 'reviewed (0|1)' with Reviews (user_id, dr_id & appmt_id composite key/unique)
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
                'source'    => ['user.slug','doctor.slug'],//'day', 
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

    // public static function boot()
    // {
    //     parent::boot();

    //     static::creating(function ($appointment) {
    //         $appointment->user_id = auth()->id();
    //         $str = str_slug($appointment->day) .'-'. auth()->user()->slug;
    //         $appointment->slug = substr($str, 0, 50);
    //     });
    // }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
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

    public function review()
    {
        return $this->hasOne(Review::class);
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

    public function absconded()
    {
        // Patient did not make payment till schedule elapsed.
        // Cron: Auto-cancelled by system after schedule elapses.
        $this->status = '6';
        $this->update();
    }
    public function autocancel()
    {
        // Doctor did not confirm 1-hour to scheduled time.
        // Cron: Auto-cancelled by system after schedule elapses.
        $this->status = '7';
        $this->update();
    }



    #~~ Status Related Scopes
    #------------------------------------------------#
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
    public function scopeAbscond($query)
    {
        // Patient did not make payment till schedule elapsed.
        return $query->where('status', '6');
    }
    public function scopeAutocanceled($query)
    {
        // Doctor did not confirm 1-hour to scheduled time.
        return $query->where('status', '7');
    }

    public function scopeReviewed($query)
    {
        // Consultation completed successfully and is reviewed by patient.
        return $query->where('reviewed', '1');
    }

    /*<!---------------- Update Doctor Application Status ---------------->*/
    public static $appointmentStatus = array(
        0 => 'Awaiting doctor\'s confirmation',

        1 => 'Success',

        2 => 'Appointment accepted by doctor. Awaits fee payment',

        3 => 'Rejected by doctor!',

        4 => 'Cancelled by patient!',
        
        5 => 'Fee paid, awaiting appointment time.',

        6 => 'Schedule time elapsed! Patient absconded.',// Payment not made by patient

        7 => 'Doctor did not confirm 1-hour to scheduled time.',

        8 => 'Something fishy.',
    );

    public static $appointmentStatusColor = array(
        0 => 'indigo',

        1 => 'teal',

        2 => 'orange',

        3 => 'red',

        4 => 'red',
        
        5 => 'orange',

        6 => 'red',

        7 => 'red',

        8 => 'red',
    );

    // If the status code is not in the provided list above return 'something fishy'.
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
    /****** ------------------ ******/
    public function getLinkAttribute()
    {
      return route('appointments.show', $this);
    }

    public function makeTransactionId() {
        return strtoupper('con'. date('Ymd') .'-'. str_random(18));
    }


    #~~ Time/Schedule Related
    #------------------------------------------------#
    public function getWithinBookingTimeLimitAttribute($value)
    {
        // All bookings must be done 1 hour before appointment starts.
        return Carbon::now() < Carbon::parse($this->from)->subHour();
    }

    public function getDayAttribute($value)
    {
        return Carbon::parse($value)->format('M d, Y');
    }

    // Formatted for edit form.
    public function getDayEditAttribute($value)
    {
        return Carbon::parse($this->day)->format('Y-m-d');
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
        $hour_hand = $hour_duration > 0 ? $hour_duration .'hr' : '';

        $mins_duration = $duration % 60;
        $mins_hand = $mins_duration > 0 ? $mins_duration .'mins' : '';

        return $hour_hand .' '. $mins_hand;
    }

    public function getNoOfSessionsAttribute()
    {
        $duration  = Carbon::parse($this->end_time)->diffInMinutes(Carbon::parse($this->start_time));

        $no_of_sessions = ceil($duration / $this->doctor->session);

        return $no_of_sessions;
    }

    public function getFeeAttribute()
    {
        $fee = $this->no_of_sessions * $this->doctor->rate;
        
        return $fee;
    }

    // Appointment time and duration is now in the past.
    public function getScheduleAttribute($value)
    {
        $schedule = $this->start_time .' - '. $this->end_time;

        return $schedule;
    }

    // Appointment time and duration is now in the past.
    public function getScheduleIsPastAttribute($value)
    {
        return Carbon::now() > Carbon::parse($this->to);
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
      $descr_preview = substr($this->description, 0, 100);
      
      return strlen($this->description) > 100 ? $descr_preview .'...':$this->description;
    }
    


    #~~ Status Related
    #------------------------------------------------#
    public function getRatingAttribute($value)
    {
      // return $this->review ? intval($this->review->rating) : 0;
      return $value ?: 0;
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
