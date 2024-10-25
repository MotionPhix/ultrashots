<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Company extends Model
{
  use HasFactory;

  protected $fillable = [
    'name',
    'slogan',
    'department',
    'banned',
    'url',
    'slug',
  ];

  protected $casts = [
    'created_at' => 'date:d m, Y',
    'banned' => 'boolean',
  ];

  public function contacts(): HasMany
  {
    return $this->hasMany(Contact::class);
  }

  public function Groups(): HasMany
  {
    return $this->hasMany(Group::class);
  }

  public function scopeOrderByName(Builder $query)
  {
    return $query->orderBy('name');
  }

  public function settings()
  {
    return $this->hasMany(Setting::class);
  }

  public function subscription(): BelongsTo
  {
    return $this->belongsTo(Subscription::class);
  }

  public function getSetting($key)
  {
    return $this->settings()->where('key', $key)->first()->value ?? null;
  }

  public function setSetting($key, $value)
  {
    return Setting::setSetting($this->id, $key, $value);
  }

  protected static function boot()
  {

    parent::boot();

    static::creating(function ($company) {

      $company->fid = Str::orderedUuid();

      $company->slug = Str::slug($company->name);

    });

  }
}
