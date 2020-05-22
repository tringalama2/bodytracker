<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Entry;
use Faker\Generator as Faker;

$factory->define(Entry::class, function (Faker $faker) {
    return [
      //'user_id' => factory(App\User::class),
      'entry_date' => $faker->date(),
      'weight_lbs' => $faker->randomFloat(1, 120, 220),
      'chest_circ_in' => $faker->randomFloat(1, 10, 20),
      'waist_circ_in' => $faker->randomFloat(1, 28, 42),
    ];
});
