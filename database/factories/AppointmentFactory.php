<?php

use Faker\Generator as Faker;

$factory->define(App\Appointment::class, function (Faker $faker) {
    $id          = App\User::all()->random()->id;
    $slug        = App\User::find($id)->slug;

    return [
      'status'    => $faker->numberBetween(0,5),
      'user_id'   => $id,
      'slug'      => $slug,
      'doctor_id' => App\Doctor::all()->random()->id,

      'day'       => $faker->dateTimeBetween('-50 day', '-1day'),
      'from'      => $faker->time('H:i', '5:00 am'), // 'H:i:s'
      'to'        => $faker->time('H:i', '11:00 pm'), // 'H:i:s'

      'description' => $faker->paragraphs(1,3),
      'illness_duration' => $faker->randomElement(['1 week','2 days','3 months']),
      'illness_history'  => $faker->sentences(1,5),

      'sealed_at' => $faker->dateTimeBetween('-50 day', '-1day'),
      'reviewed'  => $faker->boolean(40),
      
      'type'      => $faker->randomElement(['Online','Home']),
      'address'   => $faker->address,
      'phone'     => $faker->e164PhoneNumber,
    ];
});
