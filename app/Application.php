<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    protected $dates = ['first_appointment'];

    protected $fillable = [
      'user_id','specialty_id','first_appointment',
      'workplace','workplace_address','workplace_start',
      'workplace2','workplace2_address','workplace2_start','workplace2_end',
      'specialist_diploma','competences','malpraxis',
      'medical_college','medical_college_expiry',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
