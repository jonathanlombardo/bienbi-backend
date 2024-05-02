<?php

namespace Database\Seeders;

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
        for($i = 0; $i < 500; $i++){
            
          // $property = new Property();

          //creo nuovo oggetto
          $newView = new View();
          // $newView->property_id = $property->id;
          $date = $faker->dateTimeBetween("-1 year", "now");

          //salvo
          $newView->save();
        }
    }
}
