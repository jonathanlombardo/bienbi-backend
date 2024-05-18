<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Service extends Model
{
  use HasFactory, SoftDeletes;

  protected $fillable = ['label', 'icon'];

  protected $appends = ['faIconClass'];

  public function appartments()
  {
    return $this->belongsToMany(Appartment::class);
  }

  public function getFaIconClassAttribute()
  {
    return config('service_icon_class')[$this->label];
  }
}
