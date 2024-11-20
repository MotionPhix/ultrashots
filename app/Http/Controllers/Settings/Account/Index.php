<?php

namespace App\Http\Controllers\Settings\Account;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Subscription;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\Request;
use Inertia\Inertia;

class Index extends Controller
{
  public function __invoke(Request $request)
  {
    $company = $request->user()->company;

    if ($company?->id) {
      $settings = $company->settings->pluck('value', 'key');
    } else {
      return Inertia::modal('Settings/Account/Brand', [
        'brand' => new Company()
      ]);
    }

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

      'subscription' => [
        'current' => $company->subscription
          ? $company->subscription->only([
            'id',
            'name',
            'price',
            'contact_limit',
            'email_limit',
            'advanced_analytics'
          ])
          : [
            'id' => null,
            'name' => 'No Subscription',
            'price' => 0,
            'contact_limit' => 0,
            'email_limit' => 0,
            'advanced_analytics' => false,
          ],
        'available' => Subscription::whereIn('subscription_type', ['monthly', 'yearly'])
          ->get(['id', 'name', 'price', 'subscription_type']),
      ]


    ]);

    return Inertia('Settings/Account/Index', [
      'mustVerifyEmail' => fn() => $request->user() instanceof MustVerifyEmail,
      'settings' => fn() => $settings
    ]);
  }
}
