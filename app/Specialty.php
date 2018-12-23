<?php

namespace App;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class Specialty extends Model
{
    use Sluggable;

    protected $dates = ['accepted_at'];

    public $timestamps = false;

    protected $appends = ['link','description_preview','doctors_count'];

    protected $fillable = ['name','slug','description','user_id','accepted_at'];

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

    // public static function boot()
    // {
    //     parent::boot();

    //     static::creating(function ($specialty) {
    //         $specialty->user_id = auth()->id();
    //     });
    // }

    // public function doctors()
    // {
    //   return $this->belongsToMany(Doctor::class, 'doctor_specialty', 'id', 'id');
    // }

    public function user()
    {
      return $this->belongsTo(User::class);
    }

    public function doctors()
    {
      return $this->hasMany(Doctor::class);
    }

    public function getDoctorsCountAttribute()
    {
      return $this->hasMany(Doctor::class)->count();
    }

    public function tags()
    {
      // return $this->belongsToMany(Tag::class);
      return $this->hasMany(Tag::class);
    }

    public function applications()
    {
      return $this->hasMany(Application::class);
    }


    public function getLinkAttribute()
    {
      return route('specialties.show', $this);
    }

    public function getDescriptionPreviewAttribute()
    {
      $descr_preview = substr($this->description, 0, 120);
      
      return strlen($this->description) > 120 ? $descr_preview .'...':$this->description;
    }
}
