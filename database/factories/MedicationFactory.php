<?php

use Faker\Generator as Faker;

$factory->define(App\Medication::class, function (Faker $faker) {
    return [
        'user_id'         => App\User::all()->random()->id, 
        'title'           => $faker->word,
        'prescription_id' => App\Prescription::all()->random()->id, 
        'appointment_id'  => App\Appointment::all()->random()->id, 
        'description'     => $faker->sentences(2,3), 
        'start_date'      => $faker->dateTimeBetween('1 day', '3 days'),
        'start_time'      => $faker->time,
        'end_date'        => $faker->dateTimeBetween('5 days', '2 weeks'),
        'notify_by'       => $faker->numberBetween(10, 45), 
        'recurrence'      => $faker->numberBetween(2, 60), 
        'recurrence_type' => $faker->randomElement(['minutes', 'hours', 'days', 'weeks', 'months', 'years']),
    ];
});
