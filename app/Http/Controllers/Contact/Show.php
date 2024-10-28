<?php

namespace App\Http\Controllers\Contact;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Inertia\Inertia;

class Show extends Controller
{
  public function __invoke(Contact $contact)
  {
    $user = auth()->user();

    if (!$user->can('manage-everything') && $contact->company_id !== $user->company_id) {

      abort(403, 'Unauthorized access to this contact.');

    }

    $contactsQuery = \App\Models\Contact::query()->with('company');

    if (!$user->can('manage-everything')) {

      $contactsQuery->where('company_id', $user->company_id);

    }

    $contacts = $contactsQuery->orderBy('first_name')->get()->groupBy(fn ($contact) => $contact->first_name[0]);

    $contactsArray = $contacts->toArray();

    return Inertia::render('Contacts/Show', [
      'baseGroup' => $contactsArray,
      'contact' => $contact->load(
        'phones:id,model_id,type,number,formatted',
        'emails:id,model_id,email',
        'work:id,name,url,slogan',
        'work.address:id,model_id,street,city,state,country',
        'tags'
      ),
    ]);
  }
}
