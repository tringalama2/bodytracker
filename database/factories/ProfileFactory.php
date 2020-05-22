<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Profile;
use Faker\Generator as Faker;

$factory->define(Profile::class, function (Faker $faker) {
    return [
        //'user_id' => factory(App\User::class),
        'activity_level_id' => $faker->randomElement($array = array (1, 2, 3, 4, 5)),
        'gender' => $faker->randomElement($array = array ('m','f')),
        'birth_date' => $faker->dateTimeBetween(
            $startDate = '-70 years',
            $endDate = '-16 years',
            $timezone = null,
          ),
        'height_in' => $faker->randomFloat(2, 50, 70),
        'start_weight_lbs' => $faker->randomFloat(1, 120, 220),
    ];
});
