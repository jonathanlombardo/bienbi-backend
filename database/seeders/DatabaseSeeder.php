<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\ViewSeeder;



class DatabaseSeeder extends Seeder
{
  /**
   * Seed the application's database.
   *
   * @return void
   */
  public function run()
  {
    // \App\Models\User::factory(10)->create();

    // \App\Models\User::factory()->create([
    //     'name' => 'Test User',
    //     'email' => 'test@example.com',
    // ]);

    $this->call([
      UserSeeder::class,
      AppartmentSeeder::class,
      PlanSeeder::class,
      ServiceSeeder::class,
      MessageSeeder::class,
      ViewSeeder::class,
      AppartmentServiceSeeder::class,
      AppartmentPlanSeeder::class,

    ]);
  }
}
