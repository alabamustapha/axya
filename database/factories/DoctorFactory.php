<?php

use Faker\Generator as Faker;

$factory->define(App\Doctor::class, function (Faker $faker) {
    $id          = App\User::all()->random()->id;
    $slug        = App\User::find($id)->slug;

    $name        = $faker->randomElement(['Medical School','College','University']);
    $grad_school = ucfirst($faker->word) . ' '. $name .', '. $faker->country;/* '. $faker->city .',*/

    return [        
      'id'               => $id,
      'user_id'          => $id,
      'slug'             => $slug,
      'specialty_id'     => App\Specialty::all()->random()->id,
      'first_appointment'=> $faker->dateTimeBetween('-10 year', '-1 year'),
      'graduate_school'  => $grad_school,
      'available'        => $faker->boolean(85),
      'subscription_ends_at' => $faker->dateTimeBetween('-5 day', '30 day'),
      'verified_by'      => App\User::all()->random()->id,
      'verified_at'      => $faker->dateTimeBetween('-50 day', '-16 minute'),
    ];
});
