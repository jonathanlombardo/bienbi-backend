<?php

namespace Database\Seeders;

use App\Models\Appartment;
use App\Models\Service;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class AppartmentServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $appartments = Appartment::all();
        $services = Service::all()->pluck('id');

        foreach( $appartments as $appartment){
            $random_services = $faker->randomElements($services, rand(3,10));
            $appartment->services()->sync($random_services);
        };
    }
}
