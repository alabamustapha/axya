<?php

namespace App;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use Sluggable;

    protected $dates = ['accepted_at'];

    protected $with = ['specialty'];

    protected $appends = ['link','description_preview'];

    protected $fillable = ['name','slug','description','specialty_id','user_id','accepted_at'];

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

    public function specialty()
    {
      // return $this->belongsToMany(Specialty::class);
      return $this->belongsTo(Specialty::class);
    }

    public function getLinkAttribute()
    {
      return route('tags.show', $this);
    }

    public function getDescriptionPreviewAttribute()
    {
      $descr_preview = substr($this->description, 0, 120);
      
      return strlen($this->description) > 120 ? $descr_preview .'...':$this->description;
    }
}
