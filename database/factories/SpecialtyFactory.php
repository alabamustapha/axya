<?php

use Faker\Generator as Faker;

$factory->define(App\Specialty::class, function (Faker $faker) {
    $name = $faker->randomElement(['Opthamology','Gynaecology','Dentistry','Dermatology','Oncology']);

    return [
        'name'        => $name,
        'slug'        => str_slug($name),
        'description' => $faker->sentences(1,3),
        'user_id'     => App\User::all()->random()->id,
        'accepted_at' => $faker->dateTimeBetween('-10 day', '-16 minute'),
    ];
});
