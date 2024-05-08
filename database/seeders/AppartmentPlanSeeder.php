<?php

namespace Database\Seeders;

use App\Models\Appartment;
use App\Models\Plan;
use Carbon\CarbonInterval;
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
    $plans = Plan::all();

    foreach ($appartments as $appartment) {
      // sponsorizzo o meno (random) ogni appartamento
      if (rand(0, 1)) {
        // recupero un piano casuale
        $random_plan = $faker->randomElement($plans);
        // recupero l'intervallo del piano
        $plan_interval = CarbonInterval::createFromFormat('H:i:s', $random_plan->time);
        // collego il piano all'appartamento
        $appartment->plans()->attach($random_plan->id, ['date_of_issue' => now(), 'expired_at' => now()->add($plan_interval)]);
      }
    }
  }
}
