<?php

namespace App\Http\Controllers\Settings\Account;

use App\Http\Controllers\Controller;
use App\Models\Account as AccountModel;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\Request;
use Inertia\Inertia;

class Update extends Controller
{
  public function __invoke(Request $request)
  {
    return Inertia::render('Settings/Account/Index', [
      'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
      'status' => session('status'),
      'account' => $request->user()->account ?? new AccountModel()
    ]);
  }
}
