<?php

use Faker\Generator as Faker;

$factory->define(App\Message::class, function (Faker $faker) {
    $model_type= $faker->randomElement(['App\Appointment'/*,'App\Complaint',*/]);

    return [
      'user_id'       => factory(App\User::class)->create()->id,
      'body'          => $faker->sentences(2,5),

      'messageable_id'=> $faker->numberBetween(1,5),
      'messageable_type'=> $model_type,
    ];
});