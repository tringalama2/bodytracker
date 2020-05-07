<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Profile;
use Faker\Generator as Faker;

$factory->define(Profile::class, function (Faker $faker) {
    return [
        'gender' => $faker->randomElement($array = array ('m','f')),
        'height_in' => $faker->randomFloat(2, 50, 70),
        'start_weight_lbs' => $faker->randomFloat(1, 120, 220),
    ];
});
