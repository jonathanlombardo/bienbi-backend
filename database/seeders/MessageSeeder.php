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
  // public function run()
  // {
  //   $appartments = Appartment::all()->pluck('id')->toArray();
  //   foreach ($appartments as $appartment) {
  //     for ($i = 0; $i < 4; $i++) {
  //       Message::create([
  //         'body' => 'Contenuto per appartamento ' . $appartment,
  //         'mail' => 'cicciopasticcio@example.com',
  //         'first_name' => 'Nome',
  //         'last_name' => 'Cognome',
  //         'appartment_id' => $appartment
  //       ]);
  //     }
  //   }
  // }  
  public function run()
  {
    $file = fopen(__DIR__ . "/../csv/message.csv","r"); //apro il csv
    $first_line = true; //ignoro la prima riga
    while (!feof($file)) {
        $message_data = fgetcsv($file);
        if ($message_data) {

        if (!$first_line) {
            $message = new Message;
            $message->body = $message_data[0];
            $message->mail = $message_data[1];
            $message->first_name = $message_data[2];
            $message->last_name = $message_data[3];
            $message->appartment_id = $message_data[4];
            $message->created_at = $message_data[5];

            $message->save();

        }
        $first_line = false;
    }
    }

}
}
