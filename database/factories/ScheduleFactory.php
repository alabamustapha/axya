<?php

use Faker\Generator as Faker;

$factory->define(App\Schedule::class, function (Faker $faker) {
    return [
      'doctor_id' => App\Doctor::all()->random()->id,
      'day_id'    => App\Day::all()->random()->id,
      'start_at'  => $faker->time('2', '5'),
      'end_at'    => $faker->time('17', '23'),
    ];
});
