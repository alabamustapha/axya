<?php

use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(App\CalendarEvent::class, function (Faker $faker) {
    $eType = $faker->randomElement(['App\Appointment', 'App\PattAppointment', 'App\Medication', 'App\Transaction']);
    $eventType   = '';
    $eventableId = '';
    $eventClass  = '';
    $eventIcon   = '';
    
    if ($eType == 'App\Appointment') {
        $eventType   = 'App\Appointment';
        $eventTitle  = 'Patient Appointment';
        $eventableId = App\Appointment::all()->random()->id;
        $eventClass  = $faker->randomElement(['online-appointment', 'home-appointment']);
        $eventIcon   = 'fa-procedures';
        $eventBckgrd = false;
    }
    if ($eType == 'App\PattAppointment') {
        $eventType = 'App\Appointment';
        $eventTitle  = 'Doctor Appointment';
        $eventableId = App\Appointment::all()->random()->id;
        $eventClass  = $faker->randomElement(['online-appointment', 'home-appointment']);
        $eventIcon   = 'fa-user-md';
        $eventBckgrd = false;
    }
    if ($eType == 'App\Medication') {
        $eventType   = 'App\Medication';
        $eventTitle  = 'Medication Alert';
        $eventableId = App\Medication::all()->random()->id;
        $eventClass  = 'medication';
        $eventIcon   =  'fa-pills';
        $eventBckgrd = false;
    }
    if ($eType == 'App\Transaction') {
        $eventType   = 'App\Transaction';
        $eventTitle  = 'Appointment Fee';
        $eventableId = App\Transaction::all()->random()->id;
        $eventClass  = 'fee';
        $eventIcon   = $faker->randomElement(['fa-money-check-alt']);
        $eventBckgrd = true;
    }

    $startDate = Carbon::parse(Carbon::now()->addSeconds($faker->date('now', '2 weeks')))
                       ->format('Y-m-d')
                       ;
    $startTime = $startDate .' '. $faker->numberBetween(8, 11) .':00:00';
    $endTime   = $startDate .' '. $faker->numberBetween(12, 21) .':00:00';

    return [
        'user_id'       => App\User::all()->random()->id,
        'start'         => $startTime,//$faker->dateTimeBetween('1 hour', '3 hours'),
        'end'           => $endTime,  //$faker->dateTimeBetween('4 hours', '8 hours'),
        'title'         => $eventTitle,
        'content'       => $faker->sentence,
        'contentFull'   => $faker->sentences(2,4),

        'class'         => $eventClass,
        'icon'          => $eventIcon,
        'background'    => $eventBckgrd,
        'eventable_id'  => $eventableId,
        'eventable_type'=> $eventType,
    ];
});
