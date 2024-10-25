<?php

namespace App\Http\Controllers\Contact;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class Index extends Controller
{
  public function __invoke(Request $request)
  {
    $user = $request->user();

    $contactsQuery = \App\Models\Contact::query();

    if (!$user->can('manage-everything')) {

      $contactsQuery->where('company_id', $user->company_id);

    }

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
