<?php

namespace App\Http\Requests\Tag;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class TagRequest extends FormRequest
{
  public function authorize()
  {
    return true;
  }

  public function rules()
  {
    $tagId = $this->route('tag') ? $this->route('tag')->id : null;

    return [
      'name' => [
        'required',
        Rule::unique('tags', 'slug')->where(fn ($query) => $query->where('slug', '!=', Str::slug($this->name)))->ignore($tagId)],
    ];
  }

  public function messages()
  {
    return [
      'name.required' => 'Category name cannot be empty',
      'name.unique' => 'A category with this name already exists',
    ];
  }
}
