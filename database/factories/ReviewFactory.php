<?php

use Faker\Generator as Faker;

$factory->define(App\Review::class, function (Faker $faker) {
    $appointment   = App\Appointment::all()->random();//where('status', '1')->get()->random();

    return [
      'comment'        => $faker->sentences(1,3),
      'user_id'        => $appointment->user_id,
      'doctor_id'      => $appointment->doctor_id,
      'appointment_id' => $appointment->id,
      'rating'         => $faker->randomElement([1,2,3,4,5]),
    ];
});
