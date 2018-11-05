<?php

namespace App;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable, Sluggable, HasApiTokens;

    protected $casts = [
        'dob' => 'date',
    ]; 

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name','slug','email','password','address','phone','gender','avatar','is_doctor','blocked','dob','weight','height','allergies','chronics','last_four','terms',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'acl', 'last_four',
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



    public function getAvatarAttribute($value)
    {
        return (is_null($value) || $value == 'images/doc.jpg') 
                ? config('app.url') . '/images/doc.jpg' 
                : $value
                ;
    }

    public function getOriginalAvatarFileAttribute($value)
    {
        return $this->hasUploadedAvatar() ? $this->images()->first()->url:'#';
    }

    public function hasUploadedAvatar()
    {
        return $this->avatar !== config('app.url') . '/images/doc.jpg';
    }

    /**
     * Check if logged in user is the present resource owner.
     * 
     * @return boolean
     */
    public function isAccountOwner()
    {
        return $this->id === auth()->id();
    }

    /**
     * Check if logged in user is the present resource owner.
     * 
     * @return boolean
     */
    public function isVerified()
    {
        return !is_null($this->email_verified_at);
    }

    /**
     * Get actual age.
     * 
     * @return integer
     */
    public function age()
    {
        return is_null($this->dob) ? 0 : $this->dob->diffInYears(\Carbon\Carbon::now());
    }

    /**
     * Get actual age, date without h:m:s.
     * 
     * @return string
     */
    public function dob()
    {
        return is_null($this->dob) ? 'not set' : substr($this->dob, 0, 10);
    }


    /* --- - Access Control Levels - --- */

    /**
     * Chcek a user's authorization level.
     * 
     * @return boolean
     */
    public function isSuperAdmin() 
    {
        return $this->acl == 5;
    }

    public function isAdmin() 
    {
        return ($this->acl == 1 || $this->isSuperAdmin());
    }

    public function isStaff() 
    {
        return ($this->acl == 2 || $this->isAdmin());        
    }


    /**
     * Change a user's authorization level.
     * 
     * @return null
     */
    public function makeOrdinaryMember() 
    {
        $this->acl = 3;  
    } 

    public function makeStaff() 
    {
        $this->acl = 2;  
    }

    public function makeAdmin() 
    {
        $this->acl = 1;  
    }


    /* --- - User Roles - --- */

    /**
     * Prints out a user's authorization level.
     * 
     * @return null
     */
    public function type() 
    {
        if ($this->acl == 1 || $this->acl == 5){
            return 'Admin';
        } 
        elseif ($this->acl == 2){
            return 'Staff';
        }
        elseif ($this->acl == 3){
            return 'Normal User';
        }
    }

    public function isDoctor() 
    {
        return (bool) $this->doctor()->count();
    }

    public function professionalType() 
    {
        return $this->isDoctor() ? 'Doctor':'User';
    }

    public static $professionalStatus = array(
        0 => 'Are you a <i class="fa fa-user-md"></i> Medical Doctor? 
              <a class="btn btn-success btn-lg">Create a Profile Now!</a>',

        1 => '<span class="teal text-bold"><i class="fa fa-info-circle"></i>&nbsp; Notifications</span>
              <hr> 
              <small>
                Notifications and updates on professional stuffs.
                <br>
                <small class="red"><em>You must be <b>subscribed</b> to appear in search results.</em></small>
              </small>',

        2 => '<span class="green text-bold"><i class="fa fa-info-circle"></i>&nbsp; Application Accepted</span>
              <hr>
              <small>
                Your professional medical certificates has been <b>verified</b>, your application is <b>accepted</b> 
                <br>
                You can now attend to patients and receive appointments on this platform.
                <br> 
                <a href="#" class="btn btn-primary btn-lg">Subscribe now to begin</a>.
              </small>',

        3 => '<span class="orange text-bold"><i class="fa fa-info-circle"></i>&nbsp; Ongoing verification</span>
              <hr>
              <small>
                Your application as a <b>&nbsp;<i class="fa fa-user-md"></i>&nbsp; Medical Doctor</b> is receiving attention...
                <br>
                Wait for your documents verification and eventual administrator\'s decision (approval/rejection).
              </small>
                ',

        4 => '<span class="teal text-bold"><i class="fa fa-info-circle"></i>&nbsp; Application Activated!</span>
              <hr>
              <small>
                We received your intention to apply as a  <b>&nbsp;<i class="fa fa-user-md"></i>&nbsp; Medical Doctor</b> on this platform. 
                <br>
                Kindly supply all required details and documents <a href="#" class="btn btn-success btn-sm">on this page</a> 
              </small>',

        5 => '<span class="red text-bold"><i class="fa fa-info-circle red"></i>&nbsp; Application rejected!</span>
              <hr>
              <small>
                <b>We cannot accept your application as a medical doctor</b> on our platform at this time. 
                <br>
                Kindly update your documents and reapply after 1 week from {now}.
              </small>'
    );

    public function professionalStatus() 
    {
        $status = ($this->is_doctor > (sizeof(self::$professionalStatus) - 1) || $this->is_doctor < 0) ? 0 : $this->is_doctor;

        echo self::$professionalStatus[$status];
    }

    public function isActive() 
    {
        return !$this->blocked ?: false;
    }

    public function status() 
    {
        return $this->blocked ? 'Banned':'Active';
    }

    public function images()
    {
        return $this->hasMany(Image::class);
    }

    public function doctor()
    {
        return $this->hasOne(Doctor::class);
    }

    public function doctors()
    {
        $doctorIds = $this->appointments()
                          ->successful() // Scope on Appointment Class
                          ->pluck('doctor_id')
                          ->toArray();

        return App\Doctor::whereIn('id', $doctorIds)->get();
        // return $this->hasMany(Doctor::class);
    }



    /**
     * Get all doctors that has attended to this user before.
     * 
     * @return array
     */
    public function inPastAttendantDoctors()
    {
        $doctorIds = $this->doctors()
                          ->pluck('id')
                          ->toArray();

        return in_array(request()->user->id, $doctorIds);
    }
}
