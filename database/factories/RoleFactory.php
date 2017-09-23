<?php

use App\Role;
use Faker\Generator as Faker;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(Role::class, function (Faker $faker) {
    return [
        'name' => $faker->randomElement([
            'Admin',
            'Chef',
            'Student',
        ]),
    ];
});