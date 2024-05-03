<?php

namespace Database\Seeders;

use App\Models\Appartment;
use App\Models\View;
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
    for ($i = 0; $i < 500; $i++) {

      //creo nuovo oggetto
      $newView = new View();
      $newView->date = $faker->dateTimeBetween("-1 year", "now");
      $newView->ip_address = $faker->ipv4();
      $newView->appartment_id = array_rand($appartments);

      //salvo
      $newView->save();
    }
  }
}
