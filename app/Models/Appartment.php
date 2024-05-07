<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Appartment extends Model
{
  use HasFactory;

  protected $fillable = ['address', 'lng', 'lat', 'title', 'rooms', 'beds', 'bathrooms', 'square_meters'];

  protected $appends = ['imgUrl', 'isSponsored'];

  // setta uno slug unico
  public function setSlug()
  {
    $title = $this->title;
    $slugs = Appartment::where('id', '!=', $this->id)->get()->pluck('slug')->toArray();
    $baseSlug = Str::slug($title);
    $newSlug = $baseSlug;
    $counter = 0;

    while (in_array($newSlug, $slugs)) {
      $counter++;
      $newSlug = $baseSlug . "-" . $counter;
    }

    $this->slug = $newSlug;
  }

  public function getImgUrlAttribute()
  {
    return $this->image ? asset("storage/$this->image") : asset("storage/appartments/appartment_placeholder.jpg");
  }

  // verifica se l'appartamento ha una sponsorizzazione valida
  public function getIsSponsoredAttribute()
  {
    $isSponsored = false;
    foreach ($this->plans as $plan) {
      if ($plan->pivot->expired_at > now()) {
        $isSponsored = true;
        break;
      }
    }
    return $isSponsored;
  }


  //RELAZIONI

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
    return $this->belongsToMany(Plan::class)->withPivot('expired_at', 'date_of_issue');
  }
  public function services()
  {
    return $this->belongsToMany(Service::class);
  }

  static function fromSlugToAppartment($slug)
  {
    return Appartment::where('slug', $slug)->first();
  }
}
