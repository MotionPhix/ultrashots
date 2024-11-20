<?php

namespace App\Http\Middleware;

use App\Models\Company;
use Closure;
use Illuminate\Http\Request;

class EnsureUserHasCompany
{
  public function handle(Request $request, Closure $next): mixed
  {
    if ($request->user() && !$request->user()->company) {
      return Inertia('Companies/Init', [
        'brand' => new Company()
      ]);
    }

    return $next($request);
  }
}
