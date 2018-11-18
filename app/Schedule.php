<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $fillable = [ 'doctor_id','day_id','start_at','end_at', ];

    protected $appends = ['start', 'end'];

    public function doctor()
    {
      return $this->belongsTo(Doctor::class);
    }

    public function day()
    {
      return $this->belongsTo(Day::class);
    }

    /**** ~API Candidates~****/

    public function getStartAttribute()
    {
      return Carbon::parse($this->end_at)->format('H:i a');
    }

    public function getEndAttribute()
    {
      return Carbon::parse($this->end_at)->format('H:i a');
    }
}
