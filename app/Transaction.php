<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $appends = ['status_text','status_indicator'];

    protected $dates = ['confirmed_at','cancelled_at' ];

    protected $fillable = [      
        'user_id','doctor_id','appointment_id',
        // Money Related
        'amount','currency',
        // Transaction Related
        'channel','transaction_id','processor_id','processor_trxn_id','status',
        // Time Related 
        'confirmed_at','cancelled_at' 
    ];

    public function calendar_events()
    {
        return $this->morphMany(CalendarEvent::class, 'eventable');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }
    
    public function scopeCompleted($query) 
    {
        return $query->where('status', '1');
    }

    /**
     * Route key
     * 
     * @return string
     */
    public function getRouteKeyName(){
        return 'transaction_id';
    }

    public function getStatusTextAttribute()
    {
        if ($this->status == '1'){
            $status = 'Success';
        } else {
            $status = $this->status == '2' ? 'Ongoing':'Unsuccessful';
        }

        return $status;
    }

    public function getStatusIndicatorAttribute()
    {
        if ($this->status == '1'){
            $status = 'success';
        } else {
            $status = $this->status == '2' ? 'warning':'danger';
        }

        return $status;
    }
}
