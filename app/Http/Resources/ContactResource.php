<?php

namespace App\Http\Resources;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContactResource extends JsonResource
{
  /**
   * Transform the resource into an array.
   *
   * @return array<string, mixed>
   */
  public function toArray(Request $request): array
  {
    $company = $this->companies()->latest()->first();
    $company = $company->id ? $company : new Company();

    return [
      'id' => $this->id,
      'first_name' => $this->first_name,
      'last_name' => $this->last_name,
      'nickname' => $this->nickname,
      'middle_name' => $this->middle_name,
      'title' => $this->title,
      'bio' => $this->bio,
      'emails' => $this->emails,
      'phones' => $this->phones,
      'addresses' => $this->addresses,
      'company' => [
        'id' => $company->id,
        'name' => $company->name,
        'slogan' => $company->slogan,
        'address' => $company->address,
        'url' => $company->url,
        'department' => $company->pivot->department,
        'job_title' => $company->pivot->job_title,
      ],
  ];
  }
}
