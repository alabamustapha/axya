<?php

use Faker\Generator as Faker;

$factory->define(App\Application::class, function (Faker $faker) {
    $file_url  = 'http://'. $faker->domainname .'/'. $faker->slug . $faker->randomElement(['.pdf','.png','.jpeg']);
    $file_url2 = 'http://'. $faker->domainname .'/'. $faker->slug . $faker->randomElement(['.pdf','.png','.jpeg']);
    $file_url3 = 'http://'. $faker->domainname .'/'. $faker->slug . $faker->randomElement(['.pdf','.png','.jpeg']);
    $file_url4 = 'http://'. $faker->domainname .'/'. $faker->slug . $faker->randomElement(['.pdf','.png','.jpeg']);
    $region      = App\Region::all()->random();
    $city        = App\City::find($region->id); 

    return [
        'user_id'           => App\User::all()->random()->id,
        'specialty_id'      => App\Specialty::all()->random()->id,
        'first_appointment' => $faker->dateTimeBetween('-10 year', '-1 year'),
        'region_id'         => $region->id,
        'city_id'           => $city->id,        

        'workplace'         => $faker->words(1,3),
        'workplace_address' => $faker->address,
        'workplace_start'   => $faker->dateTimeBetween('-15 year', '-12 year'),

        'specialist_diploma'=> $file_url,
        'competences'       => $file_url2,
        'malpraxis'         => $file_url3,

        'medical_college'   => $file_url4,
        'medical_college_expiry' => $faker->dateTimeBetween('1 month', '12 month'),
    ];
});
