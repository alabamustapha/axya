<?php

use Faker\Generator as Faker;

$factory->define(App\Tag::class, function (Faker $faker) {
    $name = $faker->words(1,3);

    return [
        'name'        => $name,
        'slug'        => str_slug($name),
        'description' => $faker->sentence(2,5),
        'specialty_id'=> App\Specialty::all()->random()->id,
        'user_id'     => App\User::all()->random()->id,
        'accepted_at' => $faker->dateTimeBetween('-10 day', '-16 minute'),
    ];
});
