<?php

namespace App\Http\Controllers\Tag;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class Detach extends Controller
{
  public function __invoke(Request $request, Contact $contact)
  {
    $contact->detachTag($request->name, 'App\Models\Contact');

    if ($request->wantsJson()) {
      return response()->json($contact);
    }

    return redirect()->back();
  }
}
