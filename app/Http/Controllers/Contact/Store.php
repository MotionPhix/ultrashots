<?php

namespace App\Http\Controllers\Contact;

use App\Http\Controllers\Controller;
use App\Http\Requests\Contact\ContactRequest;
use App\Models\Company;
use App\Models\Contact;

class Store extends Controller
{
  public function __invoke(ContactRequest $request)
  {
    $validated = $request->validated();

    $contact = Contact::create($validated);

    if (isset($validated['phones'])) {
      $convertedPhones = [];

      foreach ($validated['phones'] as $key => $phone) {
        $convertedPhones[$key]['type'] = $phone['type'];
        $convertedPhones[$key]['country_code'] = $phone['country_code'];
        $convertedPhones[$key]['number'] = phone($phone['number'], $phone['country_code'])->formatE164();
        $convertedPhones[$key]['formatted'] = phone($phone['number'], $phone['country_code'])->formatInternational();
      }

      $contact->phones()->createMany($convertedPhones);
    }

    if (isset($validated['emails'])) {
      $contact->emails()->createMany($validated['emails']);
    }

    if (isset($validated['addresses'])) {
      $contact->addresses()->createMany($validated['addresses']);
    }

    if (isset($validated['company'])) {

      $companyData = array_intersect_key($validated['company'], array_flip(['address', 'url', 'slogan']));
      $company = Company::updateOrCreate(['id' => $validated['company']['id']], $companyData);

      $pivotData = array_intersect_key($validated['company'], array_flip(['job_title', 'department']));
      $contact->companies()->sync([$company->id => $pivotData], false);

    }

    $title = [
      'Great!',
      'Awesome',
      'That\'s about right!'
    ][rand(0, 2)];

    return redirect(route('contacts.index'))
      ->with('toast', [
        'type' => $title,
        'message' => 'Contact was added successfully!'
      ]);
  }
}
