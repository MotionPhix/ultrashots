<?php

namespace App\Http\Controllers\Contact;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Inertia\Inertia;

class Show extends Controller
{
  public function __invoke(Contact $contact)
  {
    $contactsQuery = \App\Models\Contact::query()->with('companies');

    $contacts = $contactsQuery->orderBy('first_name')->get()->groupBy(fn ($contact) => $contact->first_name[0]);

    $contactsArray = $contacts->toArray();

    return Inertia::render('Contacts/Show', [
      'baseGroup' => $contactsArray,
      'contact' => $contact->load('phones', 'emails', 'addresses', 'tags'),
    ]);
  }
}
