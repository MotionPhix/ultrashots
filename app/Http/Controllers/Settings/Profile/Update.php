<?php

namespace App\Http\Controllers\Settings\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileUpdateRequest;

class Update extends Controller
{
  /**
   * Handle the incoming request.
   */
  public function __invoke(ProfileUpdateRequest $request)
  {
    $request->user()->fill($request->validated());

    if ($request->user()->isDirty('email')) {
      $request->user()->email_verified_at = null;
    }

    if ($request->user()->save()) {

      return \redirect()->back()->with('toast', [
        'type' => 'success',
        'message' => 'Information updated'
      ]);

    }

    return \redirect()->back()->with('toast', [
      'type' => 'danger',
      'message' => 'An error occurred. Please try again'
    ]);
  }
}
