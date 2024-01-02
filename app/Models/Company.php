<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Company extends Model
{
  use HasFactory;

  protected $fillable = [
    'name',
    'slogan',
    'department',
    'address',
    'url',
    'slug',
  ];

  protected $casts = [
    'created_at' => 'date:d m, Y',
  ];

  public function contacts()
  {
    return $this->hasMany(Contact::class);
  }

  public function scopeOrderByName(Builder $query)
  {
    return $query->orderBy('name');
  }

  protected static function boot()
  {

    parent::boot();

    static::creating(function ($company) {
      $company->slug = Str::slug($company->name);
    });

  }
}
