<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        // 'slug'
        // 'avatar'
        'gender'    => $faker->randomElement(['Male','Female','Other']),
        'dob'       => $faker->dateTimeBetween('-50 year', '-16 year'),
        'password'  => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm',

        // Contact Details
        'email'     => $faker->unique()->safeEmail,
        'phone'     => $faker->e164PhoneNumber,
        'address'   => $faker->address,

        // Health Details
        'height'    => $faker->numberbetween(10,100),
        'weight'    => $faker->numberbetween(10,100),
        'allergies' => $faker->words(2,5),
        'chronics'  => $faker->sentences(1,4),

        // AUthorization Details
        'acl'       => $faker->randomElement([1,2,3,5]),
        'is_doctor' => $faker->boolean(35),
        'blocked'   => $faker->boolean(15),

        // Other Details
        // 'email_verified_at
    ];
});
