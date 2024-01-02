<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Http\Requests\Company\CompanyRequest;
use App\Models\Company;
use ProtoneMedia\Splade\Facades\Toast;

class Update extends Controller
{
  public function __invoke(CompanyRequest $request, Company $company)
  {
    $company->update($request->validated());

    Toast::title('Bravo!')
      ->success('You updated company information')
      ->leftBottom()
      ->autoDismiss(5);

    return redirect()->back();
  }
}
