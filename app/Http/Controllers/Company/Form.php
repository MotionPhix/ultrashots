<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Category;
use App\Models\Contact;

class Form extends Controller
{
  public function __invoke(Contact $contact)
  {
    $filtered_categories = Category::latest()
      ->OrderBy('name')
      ->get()
      ->transform(function ($category) {
        return [
          'value' => $category->gid,
          'label' => $category->name,
        ];
      })->toArray();

    return view('companies.form', [
      'company' => $contact->company ?? new Company(),
      'categories' => $filtered_categories,
      'contact' => $contact,
    ]);
  }
}
