<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Http\Requests\Company\CompanyRequest;
use App\Models\Company;
// use Illuminate\Http\Request;
// use ProtoneMedia\Splade\Facades\Toast;

class Store extends Controller
{
  public function __invoke(CompanyRequest $request)
  {
    $validated_company = $request->validated();

    $company = Company::create($validated_company);

    // Toast::title('Great!')
    //   ->success('A company was just created!')
    //   ->leftBottom()
    //   ->autoDismiss(5);

    if ($request->wantsJson()) {
      return response()->json($company);
    }

    return redirect()->back();
  }
}
