<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Contact;
use ProtoneMedia\LaravelCrossEloquentSearch\Search as Searcher;

class Search extends Controller
{
  public function __invoke()
  {
    // $contracts = \App\Models\Contract::search('title', request()->term)->with('contact')->get();

    $results = Searcher::new()
      // ->add(Billboard::with('township.city.country'), ['location', 'size', 'type', 'description', 'township.name', 'township.city.name', 'township.city.country.name'])
      ->add(Company::class, ['name', 'website', 'address'])
      ->add(Contact::class, ['first_name', 'last_name', 'job_title', 'email', 'bio', 'status'])
      // ->add(Invoice::with('company'), ['invoice_number', 'contact_name', 'status', 'company.name', 'issue_date', 'due_date'])
      ->beginWithWildcard()
      ->includeModelType('modelType')
      ->search(request()->q);

    return response()->json([
      'results' => $results
    ]);
  }
}
