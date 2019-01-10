<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $appends = ['status_text','status_indicator'];

    protected $dates = ['confirmed_at','cancelled_at' ];

    protected $fillable = [      
        'user_id','doctor_id','type','start','end','multiple','days',
        // Money Related
        'amount','currency',
        // Transaction Related
        'channel','transaction_id','processor_id','processor_trxn_id','status',
        // Time Related 
        'confirmed_at','cancelled_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function makeTransactionId() {
        return strtoupper('SUB'. date('Ymd') .'-'. str_random(18));
    }
    
    public function getRouteKeyName(){
        return 'transaction_id';
    }
}