<?php

use Faker\Generator as Faker;

$factory->define(App\Doctor::class, function (Faker $faker) {
    $id = App\User::all()->random()->id;
    return [        
      'id'          => $id,
      'user_id'     => $id,
      'speciality'  => $faker->randomElement(['Optician','Opthamologist','Gyneacologist','Dentist']),
      // 'status'      => $faker->boolean(65),
      'available'   => $faker->boolean(85),,
      'subscription_ends_at' => $faker->dateTimeBetween('-5 day', '3o day'),
      'verified_by' => App\User::all()->random()->id,
      'verified_at' => $faker->dateTimeBetween('-50 day', '-16 minute'),
    ];
});
