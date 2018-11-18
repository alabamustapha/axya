<?php

use Faker\Generator as Faker;

$factory->define(App\Schedule::class, function (Faker $faker) {
    return [
      'doctor_id' => App\Doctor::all()->random()->id,
      'day_id'    => App\Day::all()->random()->id,
      'start_at'  => $faker->time('H:i:s', '5:00:00'), // 'H:i:s'
      'end_at'    => $faker->time('H:i:s', '23:00:00'), // 'H:i:s'
    ];
});
