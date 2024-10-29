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
    'user_limit',
    'contact_limit',
    'email_limit',
    'advanced_analytics',
    'custom_domain',
    'support_level',
    'storage_limit',
    'subscription_type', // "monthly" or "yearly"
    'duration_in_days',
  ];

  public function companies(): HasMany
  {
    return $this->hasMany(Company::class);
  }

}
