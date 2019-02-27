<?php

use Faker\Generator as Faker;

$factory->define(App\SubscriptionPlan::class, function (Faker $faker) {
    return [
      'name'        => $faker->randomElement(['yearly', 'quarterly', 'monthly']), 
      'price'       => $faker->randomElement([1000, 2000, 3000]), 
      'description' => $faker->sentences(1,3), 
      'discount'    => $faker->numberBetween(3,8), 
    ];
});
