<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Subscription extends Model
{
  use HasFactory;

  protected $fillable = [
    'name',
    'price',
    'contact_limit',
    'email_limit',
    'advanced_analytics',
    'custom_domain',
  ];

  public function companies(): HasMany
  {
    return $this->hasMany(Company::class);
  }

}
