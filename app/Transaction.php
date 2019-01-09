<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $appends = ['status_text','status_indicator'];

    protected $fillable = [      
        'id','user_id','doctor_id','appointment_id',
        // Money Related
        'amount','currency',
        // Transaction Related
        'channel','transaction_id','processor_id','processor_trxn_id','status',
        // Time Related 
        'confirmed_at','cancelled_at' 
    ];

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
