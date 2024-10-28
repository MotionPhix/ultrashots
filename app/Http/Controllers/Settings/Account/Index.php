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

    $settings = array_merge($settings->toArray(), [

      'company' => [
        'fid' => $company->fid,
        'name' => $company->name,
        'slogan' => $company->slogan,
        'url' => $company->url,
      ],

      'address' => [
        'street' => $company->address->street ?? '',
        'city' => $company->address->city ?? '',
        'state' => $company->address->state ?? '',
        'country' => $company->address->country ?? ''
      ],

      'subscription' => $company->subscription->only([
        'advanced_analytics',
        'contact_limit',
        'email_limit',
        'price',
        'name',
      ])

    ]);

    return Inertia('Settings/Account/Index', [
      'mustVerifyEmail' => fn() => $request->user() instanceof MustVerifyEmail,
      'settings' => fn() => $settings
    ]);
  }
}
