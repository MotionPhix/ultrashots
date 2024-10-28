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
      return Inertia::render('Contacts/NotesForm', [

        'contact' => [
          'id' => $contact->id,
          'cid' => $contact->cid,
          'first_name' => $contact->first_name,
          'last_name' => $contact->last_name,
          'bio' => $contact->bio,
          'company' => $contact->company->name,
        ],

      ]);
    }

    $contact->load('phones', 'emails', 'work.address');

    // Ensure $company is an empty array if it's null
    $companyData = $contact->work
      ? [
        'id' => [
          'label' => $contact->work->name,
          'value' => $contact->work->id,
        ],
        'name' => $contact->work->name,
        'slogan' => $contact->work->slogan,
        'address' => $contact->work->address,
        'url' => $contact->work->url,
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
        'company' => $companyData,
      ],
    ]);
  }
}
