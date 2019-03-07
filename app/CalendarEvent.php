<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class CalendarEvent extends Model
{
    protected $fillable =[
      'user_id', 'start', 'end', 'title', 'content', 'contentFull', 'class', 'icon', 'background', 'eventable_id', 'eventable_type',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all of the owning messageable models.
     */
    public function eventable()
    {
        return $this->morphTo(); /* Appointment::class, Medication::class, Transaction::class */
    }

    public function type()
    {
        return (new \ReflectionClass($this->eventable_type))->getShortName();
    }

    /**
     * Creates an event to track payment of Appointment Booking Fee.
     * This is solely controlled by Appointment model.
     *
     * @source AppointmentStatusController@accept()
     */
    public static function createTransactionEventData($appointment)
    {
        return [
            // 'user_id'        => auth()->id(),
            'start'          => Carbon::now(),
            'end'            => Carbon::now()->addMinutes(60),
            'title'          => 'Appointment Fee',
            'content'        => 'Pay your appointment fee before '. Carbon::now()->addMinutes(60) .'. '. $appointment->doctor->name .' has accepted your booking.',
            'contentFull'    => 'Make your appointment booking fee payment now that '. $appointment->doctor->name .' has accepted your booking.',
            'class'          => 'fee',
            'icon'           => 'fa-money-check-alt',
            'background'     => true,
            'eventable_id'   => null,
            'eventable_type' => 'App\Transaction',
        ];
    }
}
