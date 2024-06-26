<?php

namespace App\Models;

use Carbon\CarbonInterval;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Plan extends Model
{
  use HasFactory, SoftDeletes;

  // Aggiunta proprietà fillable con i parametri necessari al fill

  protected $fillable = ["name", "time", "price"];

  public function appartments()
  {
    return $this->belongsToMany(Appartment::class)->withPivot('created_at', 'appartment_id');
  }

  public function getLabel()
  {
    return "<span class='p-1'> {$this->name} </span>";
  }

  public function getTime()
  {
    $time = CarbonInterval::createFromFormat('H:i:s', $this->time);

    if ($time->h <= 24) {
      return "$time->h ore";
    } else {
      return ($time->h / 24) . ' giorni';
    }

  }
}
