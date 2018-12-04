<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
      'user_id','body','messageable_id','messageable_type'
    ];

    /**
     * Get all of the owning messageable models.
     */
    public function messageable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function documents()
    {
        return $this->morphMany(Document::class, 'documentable');
    }
}
