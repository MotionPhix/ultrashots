<?php

namespace App\Http\Controllers\Tag;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class Update extends Controller
{
  public function __invoke(Request $request, Contact $contact)
  {
    $contactTags = $contact->tags->toArray();

    $tag = Str::title($request->name);

    if (!in_array($tag, $contactTags)) {
      $contact->attachTag($tag, 'App\Models\Contact');
    }

    if ($request->wantsJson()) {
      return response()->json($contact);
    }

    return redirect()->back();
  }
}
