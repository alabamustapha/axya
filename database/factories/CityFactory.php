<?php

use Faker\Generator as Faker;

$factory->define(App\City::class, function (Faker $faker) {
    $name = ucwords($faker->words(1,2));
    $slug = str_slug($name);

    return [
        'name'      => $name,
        'slug'      => $slug,
        'region_id' => App\Region::all()->random()->id,
    ];
});
