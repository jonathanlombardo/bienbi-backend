<?php

namespace App\Models;

use Carbon\Carbon;
use Carbon\CarbonInterval;
use Carbon\CarbonTimeZone;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Appartment extends Model
{
  use HasFactory;

  protected $fillable = ['address', 'long', 'lat', 'title', 'rooms', 'beds', 'bathrooms', 'square_meters'];

  protected $appends = ['imgUrl', 'isSponsored', 'expireSponsor'];

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

  private function expireSponsor()
  {
    // calcolo da quando deve partire la sponsorizzazione
    if ($this->plans->count() && $this->isSponsored) {
      $lastExpDate = $this->plans[0]->pivot->expired_at;
      foreach ($this->plans as $plan) {
        if ($plan->pivot->expired_at > $lastExpDate)
          $lastExpDate = $plan->pivot->expired_at;
      }
      return Carbon::createFromFormat('Y-m-d H:i:s', $lastExpDate);
    } else {
      return false;
    }
  }

  public function getExpireSponsorAttribute()
  {
    $expireDate = $this->expireSponsor();

    if ($expireDate) {
      $expireDate->tz('Europe/Rome');
      $expireDate = $expireDate->toArray();
      $day = $expireDate["day"] < 10 ? '0' . $expireDate["day"] : $expireDate["day"];
      $month = $expireDate["month"] < 10 ? '0' . $expireDate["month"] : $expireDate["month"];
      $year = $expireDate["year"] < 10 ? '0' . $expireDate["year"] : $expireDate["year"];
      $hour = $expireDate["hour"] < 10 ? '0' . $expireDate["hour"] : $expireDate["hour"];
      $minute = $expireDate["minute"] < 10 ? '0' . $expireDate["minute"] : $expireDate["minute"];
      return $day . '/' . $month . '/' . $year . " alle ore " . $hour . ':' . $minute;
    }
  }

  public function jsonViews()
  {
    return json_encode($this->views->pluck('date')->toArray());
  }

  public function jsonMessages()
  {
    return json_encode($this->messages->pluck('created_at')->toArray());
  }

  public function addSponsor(Plan $newPlan)
  {
    // calcolo da quando deve partire la sponsorizzazione
    $expireDate = $this->expireSponsor();
    $dateIssue = $expireDate ? $expireDate : now();

    // calcolo la data di scadenza
    $newPlanInterval = CarbonInterval::createFromFormat('H:i:s', $newPlan->time);
    $expDate = new Carbon($dateIssue);
    $expDate->add($newPlanInterval);

    // collego l'appartamento al piano sottoscritto
    $this->plans()->attach($newPlan->id, [
      'expired_at' => $expDate,
      'date_of_issue' => $dateIssue,
      'created_at' => now()
    ]);
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
