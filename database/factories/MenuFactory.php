<?php

use App\DiningCenter;
use App\Food;
use App\Menu;
use App\MenuTime;
use Faker\Generator as Faker;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(Menu::class, function (Faker $faker) {
    return [
        'name' => $faker->firstName,
        'food_items' => json_encode(Food::all()->map(function ($food) {
            return $food->id;
        })->random(10)),
        'dining_center_id' => DiningCenter::all()->random(1)[0]->id,
    ];
});