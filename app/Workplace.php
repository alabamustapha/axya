<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Workplace extends Model
{
    protected $fillable = [
      'id','doctor_id','name','address','start_date','end_date',
    ];

    protected $dates = ['start_date','end_date'];

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function getStartDateAttribute($value)
    {
        return Carbon::parse($value)->format('F Y');
    }

    public function getEndDateAttribute($value)
    {
        return is_null($value)? 'NA': Carbon::parse($value)->format('F Y');
    }
}
