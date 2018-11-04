<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $fillable = [ 
        'user_id','caption',
        'url','medium_url','thumbnail_url',
        'imageable_id','imageable_type','cover',
        'mime','size', 
    ];

    /**
     * Get all of the owning imageable models.
     */
    public function imageable()
    {
        return $this->morphTo();
    }

    public function user()
    {      
        // Should be handled by Imageable, but still ok as well
        return $this->belongsTo(User::class);
    }
}
