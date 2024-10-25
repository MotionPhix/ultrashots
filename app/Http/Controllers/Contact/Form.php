<?php

namespace App\Http\Controllers\Contact;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Inertia\Inertia;

class Form extends Controller
{
  public function __invoke(Contact $contact = null)
  {
    if (!$contact) {

      $contact = new Contact([
        'id' => null,
        'cid' => null,
        'first_name' => '',
        'last_name' => '',
        'middle_name' => '',
        'job_title' => '',
        'bio' => '',
      ]);

    }

    $contact->load('phones', 'emails', 'addresses', 'company');

    // Ensure $company is an empty array if it's null
    $companyData = $contact->company
      ? [
        'id' => [
          'label' => $contact->company->name,
          'value' => $contact->company->id,
        ],
        'name' => $contact->company->name,
        'slogan' => $contact->company->slogan,
        'address' => $contact->company->address,
        'url' => $contact->company->url,
      ]
      : [
        'id' => [
          'label' => '',
          'value' => ''
        ],
        'name' => '',
        'slogan' => '',
        'address' => '',
        'url' => '',
      ];

    return Inertia::render('Contacts/Form', [
      'contact' => [
        'id' => $contact->id,
        'cid' => $contact->cid,
        'first_name' => $contact->first_name,
        'last_name' => $contact->last_name,
        'middle_name' => $contact->middle_name,
        'job_title' => $contact->job_title,
        'bio' => $contact->bio,
        'emails' => $contact->emails,
        'phones' => $contact->phones,
        'addresses' => $contact->addresses,
        'company' => $companyData,
      ],
    ]);
  }
}
