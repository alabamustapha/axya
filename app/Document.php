<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $dates = ['expiry_date'];

    protected $fillable = [
      'user_id','name','description','url','documentable_id','documentable_type','issued_date','expiry_date','mime','size','unique_id',
    ];

    public function getRouteKeyName()
    {
        return 'unique_id';
    }

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

    public function isImage()
    {
        return in_array($this->mime, ['jpeg', 'png']);
    }

    public function isVideo()
    {
        return in_array($this->mime, ['mp4', 'webm', '3gp', 'avi']);
    }

    public function isAudio()
    {
        return in_array($this->mime, ['mp3', 'wav', 'ogg']);
    }

    public function isOthers()
    {
        return ! ($this->isImage() && $this->isVideo() && $this->isAudio());
    }
}
