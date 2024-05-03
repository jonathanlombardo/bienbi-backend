<?php

namespace Database\Seeders;

use App\Models\Appartment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Message;

class MessageSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $appartments = Appartment::all()->pluck('id')->toArray();
    foreach ($appartments as $appartment) {
    }
    for ($i = 0; $i < 4; $i++) {
      Message::create([
        'body' => 'Contenuto per appartamento ' . $appartment,
        'mail' => 'cicciopasticcio@example.com',
        'first_name' => 'Nome',
        'last_name' => 'Cognome',
        'appartment_id' => $appartment
      ]);
    }
  }
}
