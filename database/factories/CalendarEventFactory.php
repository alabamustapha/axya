<?php

use Faker\Generator as Faker;

$factory->define(App\CalendarEvent::class, function (Faker $faker) {
    $eType = $faker->randomElement(['App\Appointment', 'App\Medication', 'App\Transaction']);
    $eventType   = '';
    $eventableId = '';
    $eventClass  = '';
    $eventIcon   = '';
    
    if ($eType == 'App\Appointment') {
        $eventType = 'App\Appointment';
        $eventableId = App\Appointment::all()->random()->id;
        $eventClass  = $faker->randomElement(['online-appointment', 'home-appointment']);
        $eventIcon   = $faker->randomElement(['fa-hospital', 'fa-clock']);
    }
    if ($eType == 'App\Medication') {
        $eventType = 'App\Medication';
        $eventableId = App\Medication::all()->random()->id;
        $eventClass  = 'medication';
        $eventIcon   =  'fa-pills';
    }
    if ($eType == 'App\Transaction') {
        $eventType = 'App\Transaction';
        $eventableId = App\Transaction::all()->random()->id;
        $eventClass  = 'fee';
        $eventIcon   = $faker->randomElement(['fa-atm-card', 'fa-money']);
    }
    // dd(
    // $eventType  ,
    // $eventableId,
    // $eventClass ,
    // $eventIcon);

    // $eventClass = $faker->randomElement(['online-appointment', 'home-appointment', 'others', 'fee', 'medication']);
    // $eventIcon = $faker->randomElement(['fa-hospital', 'fa-clock', 'fa-atm-card', 'fa-money', 'fa-pills']);

    return [
        'user_id'       => App\User::all()->random()->id,
        'start'         => $faker->dateTimeBetween('1 hour', '2 hours'),
        'end'           => $faker->dateTimeBetween('2 hours', '3 hours'),
        'title'         => $faker->word,
        'content'       => $faker->sentence,
        'contentFull'   => $faker->sentences(2,4),

        'class'         => $eventClass,
        'icon'          => $eventIcon,
        'background'    => $faker->boolean(6),
        'eventable_id'  => $eventableId,
        'eventable_type'=> $eventType,
    ];
});
