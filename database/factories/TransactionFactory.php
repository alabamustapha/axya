<?php

use Faker\Generator as Faker;

$factory->define(App\Transaction::class, function (Faker $faker) {
    return [
      'user_id'         => App\User::all()->random()->id,
      'doctor_id'       => App\Doctor::all()->random()->id,
      'appointment_id'  => App\Appointment::all()->random()->id,
    ];
});
