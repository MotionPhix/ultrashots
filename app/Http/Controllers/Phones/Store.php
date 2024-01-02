<?php

namespace App\Http\Controllers\Phones;

use App\Http\Controllers\Controller;
use App\Http\Requests\Phone\PhoneRequest;
use App\Models\Contact;
use App\Models\Phone;

class Store extends Controller
{
  public function __invoke(PhoneRequest $request, Contact $contact)
  {
    $validated_phones = $request->validated();

    $phones = [];

    foreach ($request->phones as $key => $phone) {
      $phones[] = new Phone($phone);
    }

    $contact->phones()->saveMany($phones);

    $title = [
      'Great!',
      'Awesome',
      'That\'s about right!'
    ][rand(0, 2)];

    // Toast::title($titles[rand(0, 2)])
    //   ->success('Contact was added!')
    //   ->leftBottom()
    //   ->autoDismiss(5);

    return redirect()->back();
  }
}
