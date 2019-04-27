<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    public    $timestamps = false;
    
    protected $fillable = [ 'name', 'slug', 'region_id' ];

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function doctors()
    {
        return $this->hasMany(Doctor::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function adminNotifications()
    {
        return $this->hasMany(AdminNotification::class);
    }
}
