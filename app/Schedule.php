<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $fillable = [
      'doctor_id','day_id','start_at','end_at',
    ];

    public function doctor()
    {
      return $this->belongsTo(Doctor::class);
    }
}
