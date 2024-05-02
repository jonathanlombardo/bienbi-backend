<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $services = [
            'Wi-Fi',
            'Lavatrice',
            'Palestra',
            'Cucina',                                                        
            'Asciugatrice',
            'Spazio di lavoro dedicato',
            'Aria condizionata',
            'TV',
            'Ferro da stiro',
            'Riscaldamento',
            'Asciugacapelli',
            'Piscina',
            'Idromassaggio',
            'Parcheggio gratuito',
            'Postazione di ricarica per veicoli elettrici',
            'Culla',
            'Letto matrimoniale grande',
            'Griglia per barbecue',
            'Colazione',
            'Camino',
            'È permesso fumare',
            'Lungo la spiaggia',
            'Lungo la riva',
            'Allarme antincendio',
            'Rilevatore di monossido di carbonio'
        ];

        foreach ($services as $serviceName) {
            Service::create([
                'label' => $serviceName,
            ]);
        }
    }
}
