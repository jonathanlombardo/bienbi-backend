<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    // Aggiunta proprietà fillable con i parametri necessari al fill

    protected $fillable = ["name", "time", "price"];

    public function appartments()
    {
        return $this->belongsToMany(Appartment::class);

    }

    public function getLabel(){
        return "<span class='p-1'> {$this->name} </span>";
    }
}
