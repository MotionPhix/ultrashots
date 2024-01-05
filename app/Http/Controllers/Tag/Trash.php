<?php

namespace App\Http\Controllers\Tag;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Tags\Tag;

class Trash extends Controller
{
  public function __invoke(Request $request, Tag $tag)
  {
    $tag->update($request->validated());

    return redirect()->back();
  }
}
