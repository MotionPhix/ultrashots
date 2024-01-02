<?php

namespace App\Http\Controllers\Contact;

use App\Http\Controllers\Controller;
use App\Models\Contact;
// use Emargareten\InertiaModal\Modal;
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
        'nickname' => '',
        'middle_name' => '',
        'title' => '',
        'bio' => '',
      ]);
    }

    $contact->load('phones', 'emails', 'addresses', 'companies');
    $company = $contact->lastCompany;

    // Ensure $company is an empty array if it's null
    $companyData = $company
      ? [
        'id' => [
          'label' => $company->name,
          'value' => $company->id,
        ],
        'name' => $company->name,
        'slogan' => $company->slogan,
        'address' => $company->address,
        'url' => $company->url,
        'department' => $company->pivot->department,
        'job_title' => $company->pivot->job_title,
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
        'department' => '',
        'job_title' => '',
      ];

    return Inertia::render('Contacts/Form', [
      'contact' => [
        'id' => $contact->id,
        'cid' => $contact->cid,
        'first_name' => $contact->first_name,
        'last_name' => $contact->last_name,
        'nickname' => $contact->nickname,
        'middle_name' => $contact->middle_name,
        'title' => $contact->title,
        'bio' => $contact->bio,
        'emails' => $contact->emails,
        'phones' => $contact->phones,
        'addresses' => $contact->addresses,
        'company' => $companyData,
      ],
    ]);
  }
}
