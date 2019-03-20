<?php

use Faker\Generator as Faker;

$factory->define(App\BankAccount::class, function (Faker $faker) {
    return [
        'user_id'            => App\User::all()->random()->id,
        'bank_name'          => ucfirst($faker->word),
        'bank_acct_name'     => $faker->name, 
        'bank_account_number'=> $faker->bankAccountNumber,
    ];
});
