<?php

use Illuminate\Database\Seeder;
//importiamo il faker generator
use Faker\Generator as Faker;
//importiamo i Model
// use App\Property;
use App\Models\View;
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
          $newView->created_at = $date;
          $newView->updated_at = $date;

          //salvo
          $newView->save();
        }
    }
}
