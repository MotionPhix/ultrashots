<?php

namespace App\Http\Controllers\Phones;

use App\Http\Controllers\Controller;
use App\Http\Requests\Phone\PhoneRequest;
use App\Models\Contact;
use App\Models\Phone;
use ProtoneMedia\Splade\Facades\Toast;

class Update extends Controller
{
  public function __invoke(PhoneRequest $request, Contact $contact)
  {
    $phones = [];
    $phoneIds = [];

    foreach ($request->validated()['phones'] as $key => $phone) {
      if (isset($phone['id'])) {
        $phone_exists = Phone::find($phone['id']);

        if ($phone_exists && $phone['number'] !== $phone_exists->number) {
          $phone_exists->update($phone);
          $phones[$key] = $phone_exists;
        }

        $phoneIds[] = $phone['id'];

      } else {

        $new_phone = new Phone($phone);
        $contact->phones()->save($new_phone);
        $phones[$key] = $new_phone;

        $phoneIds[] = $new_phone->id;
      }
    }

    // Remove any phone numbers that are not in $phoneIds.
    $contact->phones()->whereNotIn('id', $phoneIds)->delete();

    Toast::title('Hooray!')
      ->success('Phones were updated')
      ->leftBottom()
      ->autoDismiss(5);

    return redirect()->back();
  }
}
