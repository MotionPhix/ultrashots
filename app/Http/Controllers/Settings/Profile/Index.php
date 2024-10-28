<?php

namespace App\Http\Controllers\Settings\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\Request;
use Inertia\Inertia;

class Index extends Controller
{
  /**
   * Handle the incoming request.
   */
  public function __invoke(Request $request)
  {
    return Inertia::render('Settings/Profile/Index', [
      'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
      'user' => $request->user()->load('company'),
    ]);
  }
}
