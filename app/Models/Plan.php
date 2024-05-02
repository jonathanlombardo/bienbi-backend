<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    // Aggiunta proprietà fillable con i parametri necessari al fill
    public $fillable=["name" , "time" , "price"];
}
