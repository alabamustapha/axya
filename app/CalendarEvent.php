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

    /**
     * Creates an event to notify a patient of an upcoming Appointment.
     * Activated the moment a patients makes a successful booking payment transaction.
     *
     * @source TransactionController@mockedPayment()
     */
    public static function patientAppointmentEventData($transaction)
    {
        return [
            // 'user_id'        => auth()->id(),
            'start'          => $transaction->appointment->from,
            'end'            => Carbon::parse($transaction->appointment->from)
                                      ->addMinutes($transaction->appointment->duration_in_minutes),
            'title'          => 'Doctor Appointment',
            'content'        => 'You have an appointment with '. $transaction->doctor->name,
            'contentFull'    => 'You have an appointment with '. $transaction->doctor->name,
            'class'          => 'online-appointment',
            'icon'           => 'fa-user-md',
            'background'     => false,
            'eventable_id'   => $transaction->appointment_id,
            'eventable_type' => 'App\Appointment',
        ];
    }

    public static function doctorAppointmentEventData($transaction)
    {
        return [
            // 'user_id'        => auth()->id(),
            'start'          => $transaction->appointment->from,
            'end'            => Carbon::parse($transaction->appointment->from)
                                      ->addMinutes($transaction->appointment->duration_in_minutes),
            'title'          => 'Patient Appointment',
            'content'        => 'You have an appointment with '. $transaction->user->name,
            'contentFull'    => 'You have an appointment with '. $transaction->user->name,
            'class'          => 'online-appointment',
            'icon'           => 'fa-procedures',
            'background'     => false,
            'eventable_id'   => $transaction->appointment_id,
            'eventable_type' => 'App\Appointment',
        ];
    }

    /**
     * Creates an event to notify a patient of an upcoming Medication.
     * Activated the moment a patient adds/updates a medication.
     *
     * @source MedicationController@store()
     */
    public static function medicationEventData($medication)
    {
        /**
         * This TEST is perfect here. A reference to Medication recurrence calculation
         * - Get the diff between the Start and End datetime,
         *   convert to minutes (smallest unit of recurrence type).
         */
        // Get total span of medication (in mins).
        $medicationDuration = Carbon::parse($medication->start_time)->diffInMinutes($medication->end_date);  

        // Get base recurrence type (in mins).
        $recurrenceMinutes = $medication->reccurrenceInMinutes[$medication->recurrence_type]; 

        // Time between each recurrence (in mins). This gets next recurrence!
        $recurrenceDuration   = $recurrenceMinutes * $medication->recurrence;  

        // Get total count of recurrence.
        $recurrenceCount   = ceil($medicationDuration / $recurrenceDuration);

        $events = [];
        for($i = 1; $i <= $recurrenceCount; $i++){
            // $index        = $i + 1;
            $scheduleMins = $i * $recurrenceDuration;
            $startTime    = Carbon::parse($medication->start_date)
                                  ->addMinutes($scheduleMins);
            array_push($events, [
                'start'          => $startTime,
                'end'            => Carbon::parse($startTime)
                                          ->addMinutes(30),
                'title'          => $medication->title,
                'content'        => $medication->description,
                'contentFull'    => 'You have a pending medication at '. $startTime .'. '. $medication->description,
                'class'          => 'medication',
                'icon'           => 'fa-pills',
                'background'     => false,
                'eventable_id'   => $medication->id,
                'eventable_type' => 'App\Medication',
            ]);
        }

        return $events;
    }
}
