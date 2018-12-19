<?php

use Faker\Generator as Faker;

$factory->define(App\Drug::class, function (Faker $faker) {
    $texture = $faker->randomElement(['tablet','capsule','caplet','liquid','powder','chewable','others']);
    return [
        'name'           => $faker->word,
        'manufacturer'   => $faker->word,
        'dosage'         => $faker->numberBetween(1,500),
        'prescription_id'=> App\Prescription::all()->random()->id,
        'usage'          => $faker->sentence,
        'comment'        => $faker->sentence,
        'texture'        => $texture,
    ];
});
