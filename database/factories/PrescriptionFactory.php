<?php

use Faker\Generator as Faker;

$factory->define(App\Prescription::class, function (Faker $faker) {
    return [
        'appointment_id' => App\Appointment::all()->random()->id,
        'message_id'     => App\Message::all()->random()->id,
        'usage'          => $faker->sentence,
        'comment'        => $faker->sentence,
    ];
});
