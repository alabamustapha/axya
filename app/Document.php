<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $dates = ['expiry_date'];

    protected $fillable = [
      'user_id','description','url','documentable_id','documentable_type','expiry_date','mime','size'
    ];

    /**
     * Get all of the owning documentable models.
     */
    public function documentable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
