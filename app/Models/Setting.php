<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Setting extends Model
{
    use HasFactory;

  protected $fillable = ['company_id', 'key', 'value'];

  public function company(): BelongsTo
  {
    return $this->belongsTo(Company::class);
  }

  // Helper to get the setting by key
  public static function getSetting($company_id, $key)
  {
    return self::where('company_id', $company_id)
      ->where('key', $key)
      ->first()
      ->value ?? null;
  }

  // Helper to update or create a setting
  public static function setSetting($company_id, $key, $value)
  {
    return self::updateOrCreate(
      ['company_id' => $company_id, 'key' => $key],
      ['value' => $value]
    );
  }
}
