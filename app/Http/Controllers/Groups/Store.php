<?php

namespace App\Http\Controllers\Groups;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\Group;
use Illuminate\Http\Request;

class Store extends Controller
{
  public function __invoke(Request $request)
  {
    $validatedGroup = $request->validate(Group::rules(auth()->id()), [
      'name.required' => 'Enter a group name',
      'name.unique' => 'Group name already exists',
      'color.required' => 'Pick a color for the group',
      'color.not_in' => 'Pick a different color',
      'contacts.required' => 'Pick at least one contact',
      'contacts.array' => 'Invalid contacts format',
      'contacts.*.exists' => 'Invalid contact information',
    ]);

    $cids = [];

    foreach($validatedGroup['contacts'] as $contact) {
      $cids[] = $contact['value'];
    };

    $syncIds = Contact::whereIn('cid', $cids)->get()
      ->transform(function ($contact) {
        return $contact->id;
      })->toArray();

    $group = auth()->user()->groups()->create($validatedGroup);

    $group->contacts()->syncWithoutDetaching($syncIds);

    return redirect()->back();
  }
}
