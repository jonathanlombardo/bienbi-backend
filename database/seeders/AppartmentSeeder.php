<?php

namespace Database\Seeders;

use App\Models\Appartment;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class AppartmentSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  // public function run(Faker $faker)
  // {
  //   // dd(asset('/storage/appartment_placeholder.jpg'));
  //   $users = User::all()->pluck('id');

  //   foreach ($users as $user) {
  //     for ($i = 0; $i < 4; $i++) {

  //       $appartment = new Appartment;
  //       $appartment->title = $faker->sentence(5);
  //       $appartment->setSlug();
  //       $appartment->rooms = rand(1, 5);
  //       $appartment->beds = rand(1, $appartment->rooms + 2);
  //       $appartment->bathrooms = rand(1, $appartment->rooms > 2 ? 2 : 1);
  //       $appartment->square_meters = rand($appartment->rooms * 20, $appartment->rooms * 40);
  //       $appartment->published = (rand(0, 1) ? true : false);
  //       $appartment->address = $faker->address();
  //       $appartment->lat = $faker->latitude(41.77, 42);
  //       $appartment->lng = $faker->longitude(12.35, 12.65);
  //       $appartment->user_id = $user;
  //       $appartment->save();
  //     }



  //   }
  // }
  public function run()
  {
      $file = fopen(__DIR__ . "/../csv/appartments.csv","r"); //apro il csv
      $first_line = true; //ignoro la prima riga
      while (!feof($file)) {
          $appartment_data = fgetcsv($file);
          if ($appartment_data) {

          if (!$first_line) {
              $appartment = new Appartment;
              $appartment->title = $appartment_data[0];
              $appartment->slug = $appartment_data[1];
              $appartment->rooms = $appartment_data[2];
              $appartment->beds = $appartment_data[3];
              $appartment->bathrooms = $appartment_data[4];
              $appartment->square_meters = $appartment_data[5];
              $appartment->published = $appartment_data[6];
              $appartment->address = $appartment_data[7];
              $appartment->lat = $appartment_data[8];
              $appartment->long = $appartment_data[9];
              $appartment->user_id = $appartment_data[10];

              $appartment->save();

          }
          $first_line = false;
      }
      }

  }
}
