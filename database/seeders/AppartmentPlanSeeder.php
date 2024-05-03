<?php

namespace Database\Seeders;

use App\Models\Appartment;
use App\Models\Plan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class AppartmentPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $appartments = Appartment::all();
        $plans_id = Plan::all()->pluck('id');

        foreach( $appartments as $appartment){
            $random_plan = $faker->randomElements($plans_id, rand(0,1));
            $appartment->plans()->sync($random_plan);
        };
    }
}
