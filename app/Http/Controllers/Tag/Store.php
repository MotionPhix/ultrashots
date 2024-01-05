<?php

namespace App\Http\Controllers\Tag;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tag\TagRequest;
use App\Models\Contact;
use Illuminate\Support\Str;
use Spatie\Tags\Tag;

class Store extends Controller
{
  public function __invoke(TagRequest $request, Contact $contact)
  {
    $validated_tag = $request->validated();

    $valid_tag = $tag = Str::title($validated_tag['name']);

    $tag = Tag::findOrCreate($valid_tag, 'App\Models\Contact');

    $contact->attachTag($tag);

    if ($request->wantsJson()) {
      return response()->json($tag);
    }

    return redirect()->back();
  }
}
