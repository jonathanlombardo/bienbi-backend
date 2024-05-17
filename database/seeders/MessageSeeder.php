<?php

namespace Database\Seeders;

use App\Models\Appartment;
use Carbon\Carbon;
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
    // recupero la dir del file
    $dir = __DIR__ . "/../csv/message.csv";


    // apro il file e ignoro la prima riga
    $file = fopen($dir, "r");
    $first_line = fgetcsv($file);

    // recupero tutti gli appartamenti
    $appartments = Appartment::all()->pluck('id')->toArray();
    foreach ($appartments as $appartment) {

      for ($i = 0; $i < 180; $i++) {
        $dt = Carbon::now()->addDay()->subDays($i);
        $n = rand(1, 10);

        for ($x = 0; $x < $n; $x++) {
          // se il file è finito, ricomincio da capo
          if (feof($file)) {
            fclose($file);
            $file = fopen($dir, "r");
            $first_line = fgetcsv($file);
          }

          // recupero i dati dal file
          $message_data = fgetcsv($file);


          if ($message_data) {
            $message = new Message;
            $message->body = $message_data[0];
            $message->mail = $message_data[1];
            $message->first_name = $message_data[2];
            $message->last_name = $message_data[3];

            $message->appartment_id = $appartment;
            $message->created_at = $dt;

            $message->save();
          }
        }
      }
    }
  }
}
