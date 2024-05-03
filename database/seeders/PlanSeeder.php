<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Recupero dati dei pacchetti di promozione

        $plans= config("plans");

        // Per ogni promozione creiamo una nuova istanza della classe Plan assegnando i dati ai relativi attributi e salvando la promozione nella tabella

        foreach($plans as $plan){
            $new_plan= new Plan();
            $new_plan->name=$plan["name"];
            $new_plan->time=$plan["time"];
            $new_plan->price=$plan["price"];
            $new_plan->save();
        }
    }
}
