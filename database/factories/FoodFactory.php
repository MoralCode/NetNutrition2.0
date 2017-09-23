<?php

use App\Food;
use Faker\Generator as Faker;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(Food::class, function (Faker $faker) {
    return [
        'name' => $faker->userName.' dish',
    ];
});