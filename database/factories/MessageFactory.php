<?php

use Faker\Generator as Faker;

$factory->define(App\Message::class, function (Faker $faker) {
    $model_type  = $faker->randomElement(['App\Appointment'/*,'App\Complaint',*/]);
    $appointment = App\Appointment::whereIn('status', ['1','5'])->get()->random();

    return [
      'user_id'       => $faker->boolean(50) ? $appointment->doctor_id : $appointment->user_id,
      'body'          => $faker->sentences(2,5),

      'messageable_id'=> $appointment->id,
      'messageable_type'=> $model_type,
    ];
});


$factory->state(App\Message::class, 'appointment', function (Faker $faker) { 
  return [
      'messageable_id'   => App\Appointment::all()->random()->id,
      'messageable_type' => 'App\Appointment',
  ];
});
