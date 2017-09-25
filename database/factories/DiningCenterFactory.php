<?php

use App\DiningCenter;
use Faker\Generator as Faker;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(DiningCenter::class, function (Faker $faker) {
    return [
        'name' => $faker->buildingNumber.' '.$faker->lastName,
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
    ];
});