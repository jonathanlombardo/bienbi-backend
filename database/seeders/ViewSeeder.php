<?php

namespace Database\Seeders;

use App\Models\Appartment;
use App\Models\View;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class ViewSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run(Faker $faker)
  {
    $appartments = Appartment::all()->pluck('id')->toArray();

    // foreach ($appartments as $appartment) {
    //   for ($i = 0; $i < 18000; $i++) {
    //     //creo nuovo oggetto
    //     $newView = new View();
    //     $newView->date = $faker->dateTimeBetween("-6 month", "+1 day");
    //     $newView->ip_address = $faker->ipv4();
    //     $newView->appartment_id = $appartment;
    //     //salvo
    //     $newView->save();
    //   }
    // }

    foreach ($appartments as $appartment) {
      for ($i = 0; $i < 180; $i++) {
        $dt = Carbon::now()->addDay()->subDays($i);
        $n = rand(1, 5);
        for ($x = 0; $x < $n; $x++) {
          //creo nuovo oggetto
          $newView = new View();
          $newView->date = $dt;
          $newView->ip_address = $faker->ipv4();
          $newView->appartment_id = $appartment;
          //salvo
          $newView->save();
        }
      }
    }


  }
}
