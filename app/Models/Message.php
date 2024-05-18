<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Message extends Model
{
  use HasFactory, SoftDeletes;
  protected $fillable = [
    'body',
    'mail',
    'first_name',
    'last_name',
    // 'appartment_id'
  ];
  public function appartment()
  {
    return $this->belongsTo(Appartment::class);
  }

  public function getAbstract($n_char)
  {
    return (strlen($this->body) > $n_char) ? substr($this->body, 0, $n_char) . '...' : $this->body;
  }
}
