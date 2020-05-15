<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ActivityLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('activity_levels')->insert([
          'id' => 1,
          'label' => 'Sedentary',
          'desc' => 'little to no exercise',
          'adjustment_level' => 1.2,
      ]);
      DB::table('activity_levels')->insert([
          'id' => 2,
          'label' => 'Light exercise',
          'desc' => '1-2 days per week',
          'adjustment_level' => 1.375,
      ]);
      DB::table('activity_levels')->insert([
          'id' => 3,
          'label' => 'Moderate exercise',
          'desc' => '3-5 days per week',
          'adjustment_level' => 1.55,
      ]);
      DB::table('activity_levels')->insert([
          'id' => 4,
          'label' => 'Heavy exercise',
          'desc' => '6-7 days per week',
          'adjustment_level' => 1.725,
      ]);
      DB::table('activity_levels')->insert([
          'id' => 5,
          'label' => 'Very heavy exercise',
          'desc' => 'twice per day, extra heavy workouts',
          'adjustment_level' => 1.9,
      ]);

    }
}
