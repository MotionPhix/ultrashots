<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class Index extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
      $company = $request->user()->company;

      if ($company) {

        return Inertia('Dashboard/Analytics', [

          'analytics' => fn() => [
            'user_count' => $company->users->count() ?? 0,
            'contact_count' => $company->contacts->count() ?? 0,
            'contact_group_count' => $company->groups->count() ?? 0,
            'sent_email_count' => rand(12, 900)
          ]

        ]);

      } else {

        return Inertia('Dashboard/Index');

      }

    }
}
