<?php

use Faker\Generator as Faker;

$factory->define(App\Workplace::class, function (Faker $faker) {
    return [
        'doctor_id' => App\Doctor::all()->random()->id,
        'name'      => $faker->words(1,3),
        'address'   => $faker->address,
        'start_date'=> $faker->dateTimeBetween('-11 year', '-8 year'),
        'end_date'  => $faker->dateTimeBetween('-7 year', '-5 year'),
    ];
});
