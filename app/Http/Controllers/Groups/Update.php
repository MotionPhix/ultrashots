<?php

namespace App\Http\Controllers\Groups;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class Update extends Controller
{
  /**
   * Handle the incoming request.
   */
  public function __invoke(Request $request, Group $group)
  {
    $this->authorize('update', $group);

    // $validated = $request->validate(Group::rules(auth()->id()), [
    //   'name.required' => 'Enter a group name',
    //   'name.unique' => 'Group name already exists',
    //   'color.required' => 'Pick a color for the group',
    //   'color.notIn' => 'Pick a different color',
    //   'contacts.required' => 'Pick at least one contact',
    //   'contacts.array' => 'Something went wrong. We didn\'t get a group of contacts',
    //   'contacts.exists' => 'Invalid contact\'s data',
    // ]);

    if ($request->has('name')) {
      $group->update($request->except(['contacts', 'id']));
    }

    if ($request->has('contacts')) {

      $cids = [];

      foreach ($request->contacts as $contact) {
        if (isset($contact['cid']) || isset($contact['value'])) {
          $cids[] = $contact['cid'] ?? $contact['value'];
        }
      }

      $contactIds = Contact::whereIn('cid', $cids)->pluck('id')->toArray();

      $group->contacts()->sync($contactIds);

    }

    return redirect()->back();
  }
}
