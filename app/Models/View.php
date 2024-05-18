<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class View extends Model
{
  use SoftDeletes;
  public function appartment()
  {
    return $this->belongsTo(Appartment::class);
  }
}
