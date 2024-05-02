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
  public function run(Faker $faker)
  {
    // dd(asset('/storage/appartment_placeholder.jpg'));
    $users = User::all()->pluck('id');

    foreach ($users as $user) {
      for ($i = 0; $i < 4; $i++) {

        $appartment = new Appartment;
        $appartment->title = $faker->sentence(5);
        $appartment->setSlug();
        $appartment->rooms = rand(1, 5);
        $appartment->beds = rand(1, $appartment->rooms + 2);
        $appartment->bathrooms = rand(1, $appartment->rooms > 2 ? 2 : 1);
        $appartment->square_meters = rand($appartment->rooms * 20, $appartment->rooms * 40);
        $appartment->image = asset('/storage/appartment_placeholder.jpg');
        $appartment->published = (rand(0, 1) ? true : false);
        $appartment->address = $faker->address();
        $appartment->lat = $faker->latitude(40, 44);
        $appartment->lng = $faker->longitude(10, 14);
        $appartment->user_id = $user;
        $appartment->save();
      }



    }
  }
}
