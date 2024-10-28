<?php

namespace App\Http\Controllers\Groups;

use App\Http\Controllers\Controller;
use App\Models\Group;
use Illuminate\Http\Request;
use Inertia\Inertia;

class Index extends Controller
{
  /**
   * Handle the incoming request.
   */
  public function __invoke(Request $request)
  {

    $user = $request->user();

    // Check if the user has 'manage-everything' permission
    if ($user->can('manage-everything')) {

      $groupsQuery = Group::query()->withCount('contacts');

    } else {
      // Otherwise, restrict to the user's company's groups
      $company = $user->company;

      if (!$company) {

        return abort(403, 'No company associated with the user.');

      }

      $groupsQuery = $company->groups()->withCount('contacts');
    }

    if ($request->wantsJson()) {
      $groups = $groupsQuery
        ->with(['contacts:id,cid,first_name,last_name'])
        ->get();

      return response()->json($groups);
    }

    return Inertia::render('Groups/Index', [

      'groupList' => $groupsQuery->get(),

    ]);

  }
}
