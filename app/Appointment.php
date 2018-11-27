<?php

namespace App;

use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use Sluggable;

    protected $dates = ['day','sealed_at'];

    protected $fillable = [
      'status','slug','user_id','doctor_id','day','from','to','patient_info','sealed_at','type','address','phone'
    ];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source'    => ['day', 'user.slug'],
                'maxLength' => 50,
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

    public function documents()
    {
        return $this->morphMany(Document::class, 'documentable');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    /**
     * Was completed successfully.
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', '1');
    }

    public function getDayAttribute($value)
    {
        return Carbon::parse($value)->format('M d, Y');
    }


    /*<!---------------- Update Doctor Application Status ---------------->*/
    public static $appointmentStatus = array(
        0 => '<span class="indigo"><i class="fa fa-info-circle"></i>&nbsp; Awaiting doctor\'s confirmation</span>',

        1 => '<span class="teal"><i class="fa fa-info-circle teal"></i>&nbsp; Success</span>',

        2 => 'Confirmed, not completed',

        3 => '<span class="orange"><i class="fa fa-info-circle"></i>&nbsp; Schedule change suggestion by doctor.</span>',

        4 => '<span class="red"><i class="fa fa-info-circle"></i>&nbsp; Rejected by doctor!</span>',

        5 => '<span class="teal"><i class="fa fa-info-circle red"></i>&nbsp; Another doctor recommended</span>',

        6 => '<span class="red"><i class="fa fa-info-circle red"></i>&nbsp; Cancelled</span>',
        
        7 => '<span class="teal"><i class="fa fa-info-circle red"></i>&nbsp; Re-opened</span>',

        8 => '<span class="red"><i class="fa fa-info-circle red"></i>&nbsp; Something fishy</span>'
    );

    // If the status code is not in the provided list above return the default '0'.
    public function statusText() 
    {
        $status = ($this->status > (sizeof(self::$appointmentStatus) - 1) || $this->status < 0) 
                    ? (sizeof(self::$appointmentStatus) + 1) // 8
                    : intval($this->status)
                    ;

        echo self::$appointmentStatus[$status];
    }
}
