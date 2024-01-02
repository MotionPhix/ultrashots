<?php

namespace App\Http\Requests\Company;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class CompanyRequest extends FormRequest
{
  public function authorize()
  {
    return true;
  }

  public function rules()
  {
    $companyId = $this->route('company') ? $this->route('company')->id : null;

    return [
      'name' => ['required', Rule::unique('companies', 'slug')->where(fn ($query) => $query->where('slug', '!=', Str::slug($this->name)))->ignore($companyId)],
      'slogan' => 'sometimes',
      'url' => 'sometimes|url',
      'address' => 'sometimes'
    ];
  }

  public function messages()
  {
    return [
      'name.required' => 'Company name cannot be empty',
      'name.unique' => 'A company with this name already exists',
      'url.url' => 'Invalid URL format',
    ];
  }
}
