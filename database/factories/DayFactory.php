<?php

use Faker\Generator as Faker;

$factory->define(App\Day::class, function (Faker $faker) {
    $days = ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];
    
    return [
        'name'      => $faker->randomElement($days),
    ];
});
