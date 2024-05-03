<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Appartment extends Model
{
  use HasFactory;

  // setta uno slug unico
  public function setSlug()
  {
    $title = $this->title;
    $slugs = Appartment::where('id', 'IS NOT', $this->id)->get()->pluck('slug')->toArray();
    $baseSlug = Str::slug($title);
    $newSlug = $baseSlug;
    $counter = 0;

    while (in_array($newSlug, $slugs)) {
      $counter++;
      $newSlug = $baseSlug . "-" . $counter;
    }

    $this->slug = $baseSlug;
  }

  public function user()
  {
    return $this->belongsTo(User::class);
  }

  public function messages()
  {
    return $this->hasMany(Message::class);
  }

  public function views()
  {
    return $this->hasMany(View::class);
  }

  public function plans()
  {
    return $this->belongsToMany(Plan::class);
  }
  public function services()
  {
    return $this->belongsToMany(Service::class);
  }
}
