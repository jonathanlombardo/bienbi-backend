<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $user = new User;
    $user->name = 'Mario';
    $user->last_name = 'Rossi';
    $user->email = 'mario.rossi@gmail.com';
    $user->password = Hash::make('password');
    $user->save();

    $user = new User;
    $user->name = 'Luigi';
    $user->last_name = 'Verdi';
    $user->email = 'luigi87@libero.it';
    $user->password = Hash::make('password');
    $user->save();
  }
}
