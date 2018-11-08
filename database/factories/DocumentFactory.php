<?php

use Faker\Generator as Faker;

$factory->define(App\Document::class, function (Faker $faker) {
    return [
      'user_id'          => App\User::all()->random()->id,
      'description'      => $faker->sentences(2,5),
      'url'              => $faker->url,
      'documentable_id'  => App\User::all()->random()->id,
      'documentable_type'=> $faker->randomElement(['App\User','App\Doctor']),// 'App\Application','App\Appointment','App\Prescription','App\Ticket','App\Transaction',
      'expiry_date'      => $faker->dateTimeBetween('1 month', '3 year'),
    ];
});
