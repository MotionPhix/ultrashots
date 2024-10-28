<?php

namespace App\Http\Controllers\Groups;

use App\Http\Controllers\Controller;
use App\Models\Group;
use Inertia\Inertia;

class Show extends Controller
{
  /**
   * Handle the incoming request.
   */
  public function __invoke(Group $group)
  {
    $user = auth()->user();

    return Inertia::render('Groups/Show', [
      'group' => $group->load('contacts')->loadCount('contacts'),
      'groups' => $user->groups->loadCount('contacts')
    ]);
  }
}
