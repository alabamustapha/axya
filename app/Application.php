<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    protected $dates = ['first_appointment'];

    protected $fillable = [
      'user_id','specialty_id','first_appointment',
      'workplace','workplace_address','workplace_start',
      'specialist_diploma','competences','malpraxis',
      'medical_college','medical_college_expiry',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function specialty()
    {
        return $this->belongsTo(Specialty::class);
    }

    public function getNameAttribute()
    {
        return $this->user->name;
    }
}
