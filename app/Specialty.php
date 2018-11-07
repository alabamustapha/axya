<?php

namespace App;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class Specialty extends Model
{
    use Sluggable;

    public $timestamps = false;

    protected $fillable = ['name','slug','description',];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    /**
     * Route key
     * 
     * @return string
     */
    public function getRouteKeyName(){
        return 'slug';
    }

    public function doctors()
    {
      return $this->belongsToMany(Doctor::class);
    }

    // public function tags()
    // {
    //   return $this->belongsToMany(Tag::class);
    // }
}
