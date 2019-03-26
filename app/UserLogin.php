<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserLogin extends Model
{
    // public $timestamps = false;

    public $dates = ['logged_out_at','last_activity_at'];

    protected $fillable = [
        'user_id',
        'ip',
        'device',
        'os',
        'type',
        'agent',

        'logged_in_seconds',
        'logged_in_minutes',
        'logged_in_hours',

        'browser',
        'referer_page',
        'exit_page',
        'session_id',
        'logged_out_at',
        'last_activity_at',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'session_id',
    ];

    public function user()
    {
      return $this->belongsTo(User::class);
    }
}
