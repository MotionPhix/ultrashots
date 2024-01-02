<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Interaction extends Model
{
  use HasFactory;

  protected $fillable = [
    'type',
    'notes'
  ];

  protected $casts = [
    'created_at' => 'date:d m, Y',
  ];

  protected static function boot()
  {

    parent::boot();

    static::creating(function ($interaction) {
      $interaction->iid = Str::uuid();
    });

  }
}
