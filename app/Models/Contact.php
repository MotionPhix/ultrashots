<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Str;
use Spatie\Tags\HasTags;

class Contact extends Model
{
  use HasFactory, SoftDeletes, HasTags;

  protected $fillable = [
    'first_name',
    'last_name',
    'bio',
    'title',
    'middle_name',
    'is_favorite',
    'user_id',
    'nickname'
  ];

  protected $casts = [
    'created_at' => 'date:d m, Y',
    'deleted_at' => 'date:d M, Y',
  ];

  protected $appends = ['last_email', 'last_phone'];

  public function company(): BelongsTo
  {
    return $this->belongsTo(Company::class);
  }

  public function Groups(): BelongsToMany
  {
    return $this->belongsToMany(Group::class, 'contact_group');
  }

  protected function fullName(): Attribute
  {
    return Attribute::make(
      get: fn ($value) => $this->first_name . ' ' . $this->last_name
    );
  }

  public function addresses(): MorphMany
  {
    return $this->morphMany(Address::class, 'model');
  }

  public function phones(): MorphMany
  {
    return $this->morphMany(Phone::class, 'model');
  }

  public function emails(): MorphMany
  {
    return $this->morphMany(Email::class, 'model');
  }

  public function lastEmail(): Attribute
  {
    return Attribute::make(
      get: fn ($value) => $this->emails()->latest()->first()
    );
  }

  public function lastPhone(): Attribute
  {
    return Attribute::make(
      get: fn ($value) => $this->phones()->latest()->first()
    );
  }

  public function scopeOrderByName($query): Builder
  {
    return $query->orderBy('first_name')->orderBy('last_name');
  }

  public function scopeOrderByCompany($query): Builder
  {
    return $query->join('companies', 'companies.id', '=', 'contacts.company_id')->orderBy('companies.name');
  }

  public function scopeOrderByField($query, $field): Builder
  {
    if ($field === 'name') {
      return $query->orderByName();
    }

    return $query->orderByCompany();
  }

  protected static function boot()
  {
    parent::boot();

    static::creating(function ($contact) {
      $contact->cid = Str::orderedUuid();

      if (auth()->check() && auth()->user()->company) {
        $contact->company_id = auth()->user()->company->id;
      }
    });

    static::updating(function ($contact) {
      if (!isset($contact->cid)) {
        $contact->cid = Str::orderedUuid();
      }
    });

    static::forceDeleting(function ($contact) {
      $contact->phones()->delete();
      $contact->emails()->delete();
      $contact->addresses()->delete();
      $contact->tags()->each(fn ($tag) => $tag->delete());
    });
  }
}
