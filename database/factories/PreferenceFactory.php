<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Preference;
use Faker\Generator as Faker;

$factory->define(Preference::class, function (Faker $faker) {
    return [
      'unit_dipslay_preference_id' => $faker->randomElement($array = array (1, 2)),
    ];
});
