<?php

namespace App\Http\Controllers\Groups;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\Group;
use Illuminate\Http\Request;

class Remove extends Controller
{
  /**
   * Handle the incoming request.
   */
  public function __invoke(Request $request, Group $group)
  {
    $this->authorize('update', $group);

    // Validate request data
    $validatedData = $request->validate([
      'contactId' => 'required|exists:contacts,id',
    ]);

    // Attach contacts to the contact list
    $group->contacts()->detach($validatedData['contactId']);

    return redirect()->back();
  }
}
