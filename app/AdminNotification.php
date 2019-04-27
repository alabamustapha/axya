<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdminNotification extends Model
{
    protected $with = ['region', 'city',];

    protected $fillable = [
        'user_id', 'as_notice', 'as_email', 'as_push', 'as_text', 
        'to', 'region_id', 'city_id', 'receiver_id', 
        'title', 'content',
    ]; 

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }
}