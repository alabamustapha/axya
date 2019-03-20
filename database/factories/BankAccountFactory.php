<?php

use Faker\Generator as Faker;

$factory->define(App\BankAccount::class, function (Faker $faker) {
    return [
        'user_id'        => App\User::all()->random()->id,
        'name'           => ucfirst($faker->word),
        'account_name'   => $faker->name, 
        'account_number' => $faker->bankAccountNumber,
    ];
});
