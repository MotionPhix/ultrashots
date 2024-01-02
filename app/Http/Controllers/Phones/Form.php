<?php

namespace App\Http\Controllers\Phones;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\Phone;

class Form extends Controller
{
  public function __invoke(Contact $contact)
  {
    // $phones = $contact->phones()->count() ? array_map(fn ($phone) => $phone instanceof Phone ? $phone : new Phone(), $contact->phones->pluck('number', 'type', 'id')) : [];

    $phones = $contact->phones()->count() ? $contact->phones->map(function ($phone) {
      return [
        'id' => $phone->id,
        'number' => $phone->number,
        'country_code' => $phone->country_code,
        'type' => $phone->type,
      ];
    })->toArray() : [new Phone()];

    // return view('phones.form', [
    //   'contact' => $contact,
    //   'phones' => empty($phones) ? new Phone() : $phones,
    // ]);

    // $phones = $contact->phones->map(function ($phone) {
    //   return $phone instanceof Phone ? $phone : new Phone();
    // })->pluck('number', 'type', 'id');

    return view('phones.form', [
      'contact' => $contact,
      'isUpdating' => $contact->phones()->count(),
      'phones' => $phones ?: [new Phone()],
    ]);

  }
}
