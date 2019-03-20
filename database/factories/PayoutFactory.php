<?php

use Faker\Generator as Faker;

$factory->define(App\Payout::class, function (Faker $faker) {
    return [
        'user_id'         => App\User::all()->random()->id,
        'amount'          => $faker->numberBetween(1000, 5000),
        'status'          => $faker->boolean(85),
        'transaction_id'  => strtoupper('pao'. date('Ymd') .'-'. str_random(18)),
        'processor_transaction_id' => strtoupper(str_random(20)),
        'bank_account_id' => App\BankAccount::all()->random()->id,
        'confirmed_at'    => $faker->dateTimeBetween('-50 day', '-1day'),
    ];
});
