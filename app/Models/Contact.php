<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
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
    'last_interaction' => 'datetime',
  ];

  protected $appends = ['last_email', 'last_company'];

  public function companies(): BelongsToMany
  {
    return $this->belongsToMany(Company::class)
      ->withPivot(['job_title', 'department'])
      ->withTimestamps();
  }

  public function Groups()
  {
    return $this->belongsToMany(Group::class);
  }

  public function interactions(): HasMany
  {
    return $this->hasMany(Interaction::class);
  }

  public function interaction(): HasOne
  {
    return $this->hasOne(Interaction::class, 'id', 'last_interaction_id');
  }

  public function scopeWithLastInteractionDate($query)
  {
    $subQuery = \DB::table('interactions')
      ->select('created_at')
      ->whereRaw('contact_id = contacts.id')
      ->latest()
      ->limit(1);

    return $query->select('contacts.*')->selectSub($subQuery, 'last_interaction_date');
  }

  public function scopeWithLastInteractionType($query)
  {
    $subQuery = \DB::table('interactions')
      ->select('type')
      ->whereRaw('contact_id = contacts.id')
      ->latest()
      ->limit(1);

    return $query->select('contacts.*')->selectSub($subQuery, 'last_interaction_type');
  }

  public function scopeWithLastInteraction($query)
  {
    $subQuery = \DB::table('interactions')
      ->select('id')
      ->whereRaw('contact_id', 'contacts.id')
      ->latest()
      ->limit(1);

    return $query->select('contacts.*')->selectSub($subQuery, 'last_interaction_id')->with('lastInteraction');
  }

  protected function fullName(): Attribute
  {
    return Attribute::make(
      get: fn ($value) => $this->first_name . ' ' . $this->last_name
    );
  }

  public function addresses(): MorphMany
  {
    return $this->morphMany(Address::class, 'addressable');
  }

  public function user(): BelongsTo
  {
    return $this->belongsTo(User::class);
  }

  public function phones(): MorphMany
  {
    return $this->morphMany(Phone::class, 'phoneable');
  }

  public function emails(): MorphMany
  {
    return $this->morphMany(Email::class, 'emailable');
  }

  public function lastEmail(): Attribute
  {
    return Attribute::make(
      get: fn ($value) => $this->emails()->latest()->first()
    );
  }

  public function lastCompany(): Attribute
  {
    return Attribute::make(
      get: fn ($value) => $this->companies()->latest()->first()
    );
  }

  public function scopeOrderByName($query)
  {
    $query->orderBy('first_name')->orderBy('last_name');
  }

  public function scopeOrderByCompany($query)
  {
    $query->join('companies', 'companies.id', '=', 'contacts.company_id')->orderBy('companies.name');
  }

  public function scopeOrderByField($query, $field)
  {
    if ($field === 'name') {
      $query->orderByName();
    } elseif ($field === 'company') {
      $query->orderByCompany();
    } elseif ($field === 'last_interaction') {
      $query->orderByLastInteractionDate();
    }
  }

  protected static function boot()
  {
    parent::boot();

    static::creating(function ($contact) {
      $contact->cid = Str::orderedUuid();
      $contact->user_id = auth()->user()->id;
    });

    static::updating(function ($contact) {
      if (!isset($contact->cid)) {
        $contact->cid = Str::orderedUuid();
      }
    });

    static::forceDeleting(function ($contact) {
      $contact->phones()->delete();
      $contact->emails()->delete();
      $contact->tags()->each(fn ($tag) => $tag->delete());
      $contact->addresses()->delete();
      $contact->companies()->delete();
    });
  }
}
