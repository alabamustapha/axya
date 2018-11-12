<?php

use Faker\Generator as Faker;

$factory->define(App\Document::class, function (Faker $faker) {
    return [
      'user_id'          => App\User::all()->random()->id,
      'name'             => $faker->name,
      'description'      => $faker->sentences(2,5),
      'url'              => $faker->url,
      'documentable_id'  => App\Application::all()->random()->id,
      'documentable_type'=> $faker->randomElement(['App\Application']),// 'App\Appointment','App\Prescription','App\Ticket','App\Transaction,'App\User','App\Doctor'',
      'issued_date'      => $faker->boolean(35) ? $faker->dateTimeBetween('-3 year', '-1 month') : null,
      'expiry_date'      => $faker->boolean(35) ? $faker->dateTimeBetween('1 month', '3 year') : null,
    ];
});
