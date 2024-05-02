<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory; 
    protected $fillable = [
        'body',
        'mail', 
        'first_name',
        'last_name',
        // 'appartment_id'
    ];
}
