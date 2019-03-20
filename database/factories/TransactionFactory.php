<?php

use Faker\Generator as Faker;

$factory->define(App\Transaction::class, function (Faker $faker) {
    $amount = $faker->numberBetween(100, 1000);
    $adminCut = setting('fee_commission') / 100; // 15% = 0.15
    $doctorEarning   = $amount * (1 - $adminCut);
    $platformEarning = $amount - $doctorEarning;

    return [
      'user_id'         => App\User::all()->random()->id,
      'doctor_id'       => App\Doctor::all()->random()->id,
      'appointment_id'  => App\Appointment::all()->random()->id,
      'transaction_id'  => strtoupper('con'. date('Ymd') .'-'. str_random(18)),
      'amount'          => $amount,
      'doctor_earning'  => $doctorEarning,
      'platform_earning'=> $platformEarning,
    ];
});
