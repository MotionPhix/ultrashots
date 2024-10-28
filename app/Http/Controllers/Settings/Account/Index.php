<?php

namespace App\Http\Controllers\Settings\Account;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\Request;
use Inertia\Inertia;

class Index extends Controller
{
  public function __invoke(Request $request)
  {
    $company = $request->user()->company;

    $settings = $company->settings->pluck('value', 'key');

    // Include address if it exists
    $address = $company->address;

    if ($address) {
      $settings = array_merge($settings->toArray(), [
        'address' => [
          'street' => $address->street,
          'city' => $address->city,
          'state' => $address->state,
          'country' => $address->country
        ]
      ]);
    }

    return Inertia('Settings/Account/Index', [
      'mustVerifyEmail' => fn() => $request->user() instanceof MustVerifyEmail,
      'settings' => fn() => $settings
    ]);
  }
}
