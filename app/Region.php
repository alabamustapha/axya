<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    public    $timestamps = false;
    
    protected $fillable = [ 'name', 'slug', 'country_id' ];

    public function cities()
    {
        return $this->hasMany(City::class);
    }

    public function doctors()
    {
        return $this->hasMany(Doctor::class);
    }

    // public function country()
    // {
    //     return $this->belongsTo(Country::class);
    // }
}