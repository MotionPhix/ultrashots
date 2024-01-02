<?php

namespace App\Http\Controllers\Contact;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class Index extends Controller
{
  public function __invoke(Request $request)
  {
    /*$contacts = \App\Models\Contact::query()
      ->when($request->filter, fn ($query, $filter) => $filter === 'favourites' ? $query->where('is_favorite', '=', True) : $query->where('deleted_at', '=', True))
      ->latest()
      ->with('companies')
      ->orderByName()
      ->get()
      ->groupBy(fn ($contact) => $contact->first_name[0]);*/

    $contactsQuery = \App\Models\Contact::query()->with('companies');

    if ($request->filter) {
      if ($request->filter === 'favourites') {
        $contactsQuery->where('is_favorite', true);
      } elseif ($request->filter === 'deleted') {
        $contactsQuery->onlyTrashed()
          ->select('first_name', 'last_name', 'deleted_at', 'id', 'cid');
      }
    }

    $contacts = $contactsQuery->orderBy('first_name')->get()->groupBy(fn ($contact) => $contact->first_name[0]);

    $contactsArray = $contacts->toArray();

    return Inertia::render('Contacts/Index', [
      'baseGroup' => $contactsArray
    ]);
  }
}
