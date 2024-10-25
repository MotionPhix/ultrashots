<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Group extends Model
{
  use HasFactory;

  protected $fillable = ['name', 'company_id'];

  public function company(): BelongsTo
  {
    return $this->belongsTo(Company::class);
  }

  public function contacts(): BelongsToMany
  {
    return $this->belongsToMany(Contact::class, 'contact_group');
  }

  public function addContacts(mixed $contactIds): void
  {
    $this->contacts()->attach($contactIds);
  }

  /**
   * Remove a contact from the group.
   *
   * @param  int|array  $contactIds
   * @return void
   */
  public function removeContacts(mixed $contactIds): void
  {
    $this->contacts()->detach($contactIds);
  }
}
