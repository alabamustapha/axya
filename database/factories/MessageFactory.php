<?php

use Faker\Generator as Faker;

$factory->define(App\Message::class, function (Faker $faker) {
    $model_type= $faker->randomElement(['App\Appointment'/*,'App\Complaint',*/]);

    return [
      'user_id'       => App\User::all()->random()->id,
      'body'          => $faker->sentences(2,5),

      'messageable_id'=> App\Appointment::all()->random()->id,
      'messageable_type'=> $model_type,
    ];
});