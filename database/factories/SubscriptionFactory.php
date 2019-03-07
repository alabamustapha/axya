<?php

use Faker\Generator as Faker;

$factory->define(App\Subscription::class, function (Faker $faker) {
    $userId = App\User::all()->random()->id;

    return [
      'user_id'         => $userId,
      'doctor_id'       => $userId,
      'subscription_plan_id' =>App\SubscriptionPlan::all()->random()->id,
      'transaction_id'  => strtoupper('SUB'. date('Ymd') .'-'. str_random(18)),
    ];
});
