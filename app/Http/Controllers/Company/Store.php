<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Http\Requests\Company\CompanyRequest;
use App\Models\Company;

class Store extends Controller
{
  public function __invoke(CompanyRequest $request)
  {
    $validated_company = $request->validated();

    if ($request->user()->company_id) return back()->with('toast', ['message' => 'You already have a brand']);

    $company = Company::create($validated_company);

    $request->user()->update(['company_id' => $company->id]);

    if ($request->wantsJson()) {
      return response()->json($company);
    }

    return redirect()->route('dashboard');
  }
}
