<?php

use App\MenuTime;
use Faker\Generator as Faker;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(MenuTime::class, function (Faker $faker) {
    return [
        'name' => $faker->userName,
        'start' => $faker->dateTimeBetween('-10 days', '-1 days'),
        'end' => $faker->dateTimeBetween('+1 days', '+10 days'),
    ];
});