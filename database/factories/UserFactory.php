<?php

use Carbon\Carbon;
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
    $region      = App\Region::all()->random();
    $city        = App\City::find($region->id); 
    
    return [
        'name'      => str_replace("'", "", $faker->name),
        // 'slug'
        // 'avatar'
        'gender'    => $faker->randomElement(['Male','Female','Other']),
        'dob'       => $faker->dateTimeBetween('-50 year', '-16 year'),
        'password'  => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm',

        // Contact Details
        'email'     => $faker->unique()->safeEmail,
        'phone'     => $faker->e164PhoneNumber,
        'address'   => $faker->address,
        'region_id' => $region->id,
        'city_id'   => $city->id,  

        // Health Details
        'height'    => $faker->numberbetween(10,100),
        'weight'    => $faker->numberbetween(10,100),
        'allergies' => $faker->words(2,5),
        'chronics'  => $faker->sentences(1,4),

        // Authorization Details
        'acl'       => $faker->randomElement([1,2,3,5]),
        'blocked'   => $faker->boolean(15),

        // Other Details
        // 'application_status' => $faker->randomElement([0,1,2,3,4,5]),
        'email_verified_at'  => $faker->boolean(15) ? $faker->dateTimeBetween('-7 week', '-5 hour') : null,
        'terms'    => '1',
    ];
});

$factory->state(App\User::class, 'normal', function (Faker $faker) { return [ 'acl' => '3' ]; });

$factory->state(App\User::class, 'verified', function (Faker $faker) {
    return [
        'acl' => '3',
        'blocked' => '0',
        'email_verified_at' => Carbon::parse('-1 day'), 
    ];
});

$factory->state(App\User::class, 'unverified', function (Faker $faker) {
    return [
        'acl' => '3',
        'blocked' => '0',
        'email_verified_at' => null, 
    ];
});

$factory->state(App\User::class, 'staff', function (Faker $faker) {
    return [
        'acl' => '2',
        'admin_mode' => 1,
        'blocked' => '0',
        'email_verified_at' => Carbon::parse('-1 day'),
        'admin_password' => 'abcdefg',
    ];
});

$factory->state(App\User::class, 'admin', function (Faker $faker) {
    return [
        'acl' => '1',
        'admin_mode' => 1,
        'blocked' => '0',
        'email_verified_at' => Carbon::parse('-1 day'),
        'admin_password' => 'abcdefg',
    ];
});

$factory->state(App\User::class, 'superadmin', function (Faker $faker) {
    return [
        'acl' => '5',
        'admin_mode' => 1,
        'blocked' => '0',
        'email_verified_at' => Carbon::parse('-1 day'),
        'admin_password' => 'abcdefg',
    ];
});

$factory->state(App\User::class, 'doctor', function (Faker $faker) {
    return [
        'is_doctor' => 1,
        'doctor_mode' => 1,
        'doctor_password' => 'abcdefg',
    ];
});
