<?php

namespace App\Http\Controllers\Groups;

use App\Http\Controllers\Controller;
use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class Trash extends Controller
{
  /**
   * Handle the incoming request.
   */
  public function __invoke(Request $request)
  {
    $validatedIds = $request->validate([
      'ids' => 'required|array',
      'ids.*' => 'string|uuid',
    ], [
      'ids.required' => 'No groups provisioned for deletion',
      'ids.array' => 'Wrong data format provided',
      'ids.*.string' => 'Modified group type detected',
      'ids.*.uuid' => 'Invalid group format detected.'
    ]);

    // $validatedIds = $validatedIds; // explode(',', $request->ids);

    $groups = Group::whereIn('gid', $validatedIds)->get();

    // Detach contacts from each group
    foreach ($groups as $group) {
      $group->contacts()->detach();
    }

    Group::whereIn('gid', $validatedIds)->delete();

    $path = app('router')->getRoutes()
      ->match(app('request')
      ->create(URL::previous()))
      ->getName();

    if ($path === 'groups.show') {

      // Get first group and load it
      $group = Group::first();

      if ($group) {
        return redirect(route('groups.show', $group->gid));
      }

      return redirect(route('groups.index'));
    }

    return redirect()->back();
  }
}
