<?php

namespace App\Http\Controllers\Groups;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\Group;
use Illuminate\Http\Request;

class Add extends Controller
{
  /**
   * Handle the incoming request.
   */
  public function __invoke(Request $request, Group $group)
  {
    $this->authorize('update', $group);

    // Validate request data
    $validatedData = $request->validate([
      'contactIds' => 'required|array',
      'contactIds.*' => 'exists:contacts,cid',
    ]);

    $idsToSave = Contact::whereIn('cid', $validatedData)->pluck('id')->toArray();

    // Attach contacts to the contact list
    $group->contacts()->syncWithoutDetaching($idsToSave);

    return redirect()->back();
  }
}
