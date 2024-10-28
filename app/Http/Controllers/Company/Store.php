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

    $company = Company::create($validated_company);

    if ($request->wantsJson()) {
      return response()->json($company);
    }

    return redirect()->back();
  }
}
