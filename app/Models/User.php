<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements HasMedia
{
  use HasApiTokens, HasFactory, Notifiable, HasRoles, InteractsWithMedia;

  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $fillable = [
    'first_name',
    'last_name',
    'banned',
    'email',
    'password',
  ];

  /**
   * The attributes that should be hidden for serialization.
   *
   * @var array<int, string>
   */
  protected $hidden = [
    'password',
    'remember_token',
  ];

  /**
   * The attributes that should be cast.
   *
   * @var array<string, string>
   */
  protected $casts = [
    'email_verified_at' => 'datetime',
    'banned' => 'boolean',
  ];

  public function company(): BelongsTo
  {
    return $this->belongsTo(Company::class);
  }

  protected function fullName(): Attribute
  {
    return Attribute::make(
      get: fn ($value) => $this->first_name . ' ' . $this->last_name
    );
  }

  public function avatarUrl(): string
  {
    // Check if the user has an avatar in the media library
    $media = $this->getFirstMedia('avatars');

    if ($media) {
      return $media->getUrl();
    }

    // Fallback to Gravatar if no avatar is found
    return 'https://www.gravatar.com/avatar/' . md5(strtolower(trim($this->email)));
  }

  public function isNotBanned(): bool
  {
    return $this->banned !== true;
  }

  protected static function boot()
  {
    parent::boot();

    static::creating(function ($user) {

      $user->uid = Str::orderedUuid();

    });

    static::created(function ($user) {

      if (User::count() === 1) {

        $user->assignRole('Super Admin');

      }

    });
  }
}
