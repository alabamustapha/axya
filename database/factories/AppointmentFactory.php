<?php

use Faker\Generator as Faker;

$factory->define(App\Appointment::class, function (Faker $faker) {
    return [
      'status'    => $faker->numberBetween(0,6),
      'user_id'   => App\User::all()->random()->id,
      'doctor_id' => App\Doctor::all()->random()->id,
      'date'      => $faker->dateTimeBetween('-50 day', '-1day'),
      'from_time' => $faker->time('H:i:s', '5:00:00'), // 'H:i:s'
      'to_time'   => $faker->time('H:i:s', '23:00:00'), // 'H:i:s'
      'patient_info' => $faker->paragraphs(1,3),
      'sealed_at'   => $faker->dateTimeBetween('-50 day', '-1day'),
    ];
});
