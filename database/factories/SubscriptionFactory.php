<?php

use Faker\Generator as Faker;

$factory->define(App\Subscription::class, function (Faker $faker) {
    $userId = App\User::all()->random()->id;
    $type   = $faker->randomElement(['1','2','3']);

    return [
      'user_id'         => $userId,
      'doctor_id'       => $userId,
      'type'            => $type,
      'transaction_id'  => strtoupper('SUB'. date('Ymd') .'-'. str_random(18)),
    ];
});
