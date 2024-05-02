<?php

namespace Database\Seeders;

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
        Message::create([
            'body' => 'Contenuto del messaggio...',
            'mail' => 'cicciopasticcio@example.com',
            'first_name' => 'Nome',
            'last_name' => 'Cognome',
            // 'appartment_id' => 1
        ]);
    }
}
