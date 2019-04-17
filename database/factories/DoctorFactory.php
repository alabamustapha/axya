<?php

use Faker\Generator as Faker;
use Carbon\Carbon;

$factory->define(App\Doctor::class, function (Faker $faker) {
    $id          = App\User::all()->random()->id;
    $slug        = App\User::find($id)->slug;

    $name        = $faker->randomElement(['Medical School','College','University']);
    $grad_school = ucfirst($faker->word) . ' '. $name .', '. $faker->country;/* '. $faker->city .',*/
    $region      = App\Region::all()->random();
    $city        = App\City::find($region->id); 

    return [        
      'id'               => $id,
      'user_id'          => $id,
      'slug'             => $slug,
      'about'            => $faker->paragraphs(2,5),
      'rate'             => $faker->numberBetween(5,1000),
      'specialty_id'     => App\Specialty::all()->random()->id,
      'first_appointment'=> $faker->dateTimeBetween('-10 year', '-1 year'),
      'graduate_school'  => $grad_school,
      'available'        => $faker->boolean(85),
      'subscription_ends_at' => $faker->dateTimeBetween('-5 day', '30 day'),
      'verified_by'      => App\User::all()->random()->id,
      'verified_at'      => $faker->dateTimeBetween('-50 day', '-16 minute'),
      'work_address'     => $faker->address,
      'email'            => $faker->email,
      'phone'            => $faker->e164PhoneNumber,
      'region_id'         => $region->id,
      'city_id'           => $city->id,  


      'main_language'    => $faker->randomElement(['1','2','3','4']),
      'country_id'       => $faker->randomElement(['1','2']),
      'rate'             => $faker->numberBetween(5,100),
      'session'          => $faker->numberBetween(30,100),
      // Education
      'graduate_school'  => $faker->catchPhrase,
      'degree'           => $faker->sentence,
    ];
});

$factory->state(App\Doctor::class, 'active', function (Faker $faker) {
    return [
        'revoked' => '0', 
        'available'=> '1',
        'subscription_ends_at'=> Carbon::parse(Carbon::now())->addYear(),
        'subscription_ends_at' => Carbon::now()->addMonth(),
        'serialized_schedules' => serialize([
            '1'=> [ 'start_at' => '01:00:00', 'end_at'   => '02:00:00' ],                
            '2'=>[],'3'=>[],'4'=>[],'5'=>[],'6'=>[],'7'=>[]
        ]),
    ];
});

$factory->state(App\Doctor::class, 'suspended', function (Faker $faker) {
    return [
        'revoked' => '1', 
    ];
});
