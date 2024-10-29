<?php

namespace App\Http\Controllers\Contact;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Inertia\Inertia;

class Form extends Controller
{
  public function __invoke(Contact $contact = null, bool $modal = false)
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

    if ($modal) {
      return Inertia('Contacts/NotesForm', [

        'contact' => [
          'id' => $contact->id,
          'cid' => $contact->cid,
          'first_name' => $contact->first_name,
          'last_name' => $contact->last_name,
          'bio' => $contact->bio,
          'office' => $contact->company->name,
        ],

      ]);
    }

    $contact->load('phones', 'emails', 'office.address');

    // Ensure $company is an empty array if it's null
    $companyData = $contact->office
      ? [
        'id' => [
          'label' => $contact->office->name,
          'value' => $contact->office->id,
        ],
        'name' => $contact->office->name,
        'slogan' => $contact->office->slogan,
        'address' => $contact->office->address,
        'url' => $contact->office->url,
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
        'office' => $companyData,
      ],
    ]);
  }
}
