<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class View extends Model
{
    public function appartment()
    {
        return $this->belongsTo(Appartment::class);
    }
}
