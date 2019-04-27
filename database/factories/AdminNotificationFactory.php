<?php

use Faker\Generator as Faker;

$factory->define(App\AdminNotification::class, function (Faker $faker) {
    $adminId  = 1;//App\User::all()->random()->id;
    // dd($adminId);
    $regionalSend = $faker->boolean(30) ? true:false;

    $receiver    = App\User::all()->random();
    $regionId    = $regionalSend ? $receiver->region_id: null;
    $cityId      = $regionalSend ? $receiver->city_id: null;
    return [
        'user_id'     => $adminId,
        'as_notice'   => $faker->boolean(60),
        'as_email'    => $faker->boolean(60),
        'as_push'     => $faker->boolean(60),
        'as_text'     => $faker->boolean(60),
        'to'          => $faker->boolean(90) 
                                ? $faker->randomElement(['Doctors','Users'])
                                : $faker->randomElement(['Everyone','Admins'])
                                ,
        'region_id'   => $regionId,
        'city_id'     => $cityId,
        'receiver_id' => $receiver->id,
        'title'       => $faker->sentence,
        'content'     => $faker->paragraphs(1,3),
    ];
});
