<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use App\Models\Category;

class Form extends Controller
{
  public function __invoke(Category $category = null)
  {
    return view('categories.form', [
      'category' => $category ?? new Category(),
    ]);
  }
}
