<?php

use App\DiningCenter;
use App\Menu;
use App\MenuTime;
use Faker\Generator as Faker;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(Menu::class, function (Faker $faker) {
    return [
        'name' => $faker->firstName,
        'dining_center_id' => DiningCenter::all()->random(1)[0]->id,
    ];
});