<?php

use Faker\Generator as Faker;

$factory->define(App\BankAccount::class, function (Faker $faker) {
    $userId   = App\User::all()->random()->id;
    $userName = App\User::find($userId)->name;
    return [
        'user_id'        => $userId,
        'name'           => ucfirst(str_replace("'", "", $faker->word)),
        'account_name'   => $userName, 
        'account_number' => $faker->bankAccountNumber,
    ];
});
