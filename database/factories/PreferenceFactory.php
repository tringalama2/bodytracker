<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Preference;
use Faker\Generator as Faker;

$factory->define(Preference::class, function (Faker $faker) {
    return [
      'user_id' => factory(App\User::class),
      'unit_dipslay_preference_id' => $faker->randomElement($array = array (1, 2)),
    ];
});
