<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Drug extends Model
{
    protected $fillable = [
      'prescription_id','name','manufacturer','dosage','usage','comment','texture'
    ];

    public function prescription()
    {
        return $this->belongsTo(Prescription::class);
    }
}
