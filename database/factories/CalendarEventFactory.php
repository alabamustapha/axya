<?php

use Faker\Generator as Faker;

$factory->define(App\CalendarEvent::class, function (Faker $faker) {
    $eventType = $faker->randomElement(['App\Appointment', 'App\Medication', 'App\Transaction']);
    $eventClass = $faker->randomElement(['online-appointment', 'home-appointment', 'others', 'fee', 'medication']);
    $eventIcon = $faker->randomElement(['fa-hospital', 'fa-clock', 'fa-atm-card', 'fa-money', 'fa-pills']);

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
        'eventable_id'  => App\Appointment::all()->random()->id,
        'eventable_type'=> $eventType,
    ];
});
