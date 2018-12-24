<?php

use Faker\Generator as Faker;

$factory->define(App\Review::class, function (Faker $faker) {
    $appointmentId = App\Appointment::all()->random()->id;
    $userId        = App\Appointment::find($appointmentId)->user_id;
    $doctorId      = App\Appointment::find($appointmentId)->doctor_id;

    return [
      'comment'        => $faker->sentences(1,3),
      'user_id'        => $userId,
      'doctor_id'      => $doctorId,
      'appointment_id' => $appointmentId,
      'rating'         => $faker->randomElement([1,2,3,4,5]),
    ];
});
