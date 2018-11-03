<?php

use Faker\Generator as Faker;

$factory->define(App\Image::class, function (Faker $faker) {
    $img_url   = $faker->imageUrl;
    $img_url_m = $img_url . '-md';
    $img_url_t = $img_url . '-tb';
    $model_type= $faker->randomElement(['App\User','App\Report','App\Officer',]);

    return [
      'user_id'       => factory(App\User::class)->create()->id,
      'caption'       => $faker->catchPhrase,

      'url'           => $img_url,
      'medium_url'    => $img_url_m,
      'thumbnail_url' => $img_url_t,

      'imageable_id'  => $faker->numberBetween(1,5),
      'imageable_type'=> $model_type,
      'main'          => $faker->boolean(95) ? '0':'1',

      'mime'          => $faker->mimeType,
      'size'          => $faker->numberBetween(200,2000), 
    ];
});