<?php

use App\DiningCenter;
use Faker\Generator as Faker;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(DiningCenter::class, function (Faker $faker) {
    return [
        'name' => $faker->buildingNumber . ' ' . $faker->lastName,
        'latitude' => $faker->latitude,
        'longitude' => $faker->longitude
    ];
});