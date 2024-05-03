<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = ['label', 'icon'];

    public function appartments()
    {
        return $this->belongsToMany(Appartment::class);
    }
}
