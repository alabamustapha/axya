<?php

use Faker\Generator as Faker;

$factory->define(App\Appointment::class, function (Faker $faker) {
    return [
      'status'    => $faker->numberBetween(0,6),
      'user_id'   => App\User::all()->random()->id,
      'doctor_id' => App\Doctor::all()->random()->id,

      'day'       => $faker->dateTimeBetween('-50 day', '-1day'),
      'from'      => $faker->time('H:i', '5:00 am'), // 'H:i:s'
      'to'        => $faker->time('H:i', '11:00 pm'), // 'H:i:s'

      'patient_info' => $faker->paragraphs(1,3),
      'sealed_at' => $faker->dateTimeBetween('-50 day', '-1day'),
      
      'type'      => $faker->randomElement(['Online','Home']),
      'address'   => $faker->address,
      'phone'     => $faker->e164PhoneNumber,
    ];
});
