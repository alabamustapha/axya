<?php

use Faker\Generator as Faker;

$factory->define(App\Document::class, function (Faker $faker) {
    $docType = $faker->randomElement(['image/png', 'video/mp4', 'application/pdf']);
    $mime       = '';
    $mimeType   = '';
    $uniqueId   = '';
    
    if ($docType == 'image/png') {
        $mime       = 'png';
        $mimeType   = 'image/png';
        $uniqueId   = str_replace('.', '', uniqid('', true) . time()) .'.'. $mime;
        $documentableType = $faker->randomElement(['App\Message', 'App\User']);
    }
    if ($docType == 'video/mp4') {
        $mime       = 'mp4';
        $mimeType   = 'video/mp4';
        $uniqueId   = str_replace('.', '', uniqid('', true) . time()) .'.'. $mime;
        $documentableType = 'App\Message';
    }
    if ($docType == 'application/pdf') {
        $mime       = 'pdf';
        $mimeType   = 'application/pdf';
        $uniqueId   = str_replace('.', '', uniqid('', true) . time()) .'.'. $mime;
        $documentableType = $faker->randomElement(['App\Message', 'App\Application']);
    }
    return [
      'user_id'          => App\User::all()->random()->id,
      'name'             => $faker->name,
      'description'      => $faker->sentences(2,5),
      'url'              => $faker->url,
      'documentable_id'  => $faker->numberBetween(1,5),//App\Application::all()->random()->id,
      'documentable_type'=> $documentableType,// 'App\Appointment','App\Prescription','App\Ticket','App\Transaction,'App\User','App\Doctor'',
      'issued_date'      => $faker->boolean(35) ? $faker->dateTimeBetween('-3 year', '-1 month') : null,
      'expiry_date'      => $faker->boolean(35) ? $faker->dateTimeBetween('1 month', '3 year') : null,
      'mime'             => $mime,
      'mime_type'        => $mimeType,
      'unique_id'        => $uniqueId,
    ];
});
