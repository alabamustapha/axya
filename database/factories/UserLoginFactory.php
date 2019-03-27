<?php

use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(App\UserLogin::class, function (Faker $faker) {

    $created_at    = $faker->dateTimeBetween('-5 days', '-2 hours');
    $logged_out_at = $faker->dateTimeBetween('-4 days', '5 minutes');
    // dd(Carbon::parse($logged_out_at), $logged_out_at);

    $logged_in_seconds = null;//Carbon::parse($logged_out_at)->diffInSeconds($created_at);
    $logged_in_minutes = null;//Carbon::parse($logged_out_at)->diffInMinutes($created_at);
    $logged_in_hours   = null;//Carbon::parse($logged_out_at)->diffInHours($created_at);

    return [
        'user_id'   => App\User::all()->random()->id,
        'ip'        => $faker->ipv4,
        'device'    => $faker->randomElement(['Mobile','Tablet','Desktop','Bot']),
        'os'        => $faker->randomElement(['Windows','Mac OS X','Linux']),
        'type'      => $faker->randomElement(['r','l','n']),
        'agent'     => $faker->userAgent,

        'logged_in_seconds'=> $logged_in_seconds ?: null,
        'logged_in_minutes'=> $logged_in_minutes ?: null,
        'logged_in_hours'  => $logged_in_hours ?: null,

        'browser'       => $faker->chrome,
        'referer_page'  => $faker->url,
        'exit_page'     => $faker->url,
        'session_id'    => strtolower(str_random(25)),
        // 'logged_in_at'   => $faker->ip,
        'logged_out_at' => $logged_out_at,
    ];
});
