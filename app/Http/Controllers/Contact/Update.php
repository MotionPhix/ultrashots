<?php

namespace App\Http\Controllers\Contact;

use App\Http\Controllers\Controller;
use App\Http\Requests\Contact\ContactRequest;
use App\Models\Address;
use App\Models\Company;
use App\Models\Contact;
use App\Models\Email;
use App\Models\Phone;

class Update extends Controller
{

  public function __invoke(ContactRequest $request, Contact $contact)
  {
    $validated = $request->validated();

    $contact->update($validated);

    if (isset($validated['phones'])) {

      $phoneIds = [];

      foreach ($request->phones as $key => $phone) {

        $phone['number'] = phone($phone['number'], $phone['country_code'])->formatE164();
        $phone['formatted'] = phone($phone['number'], $phone['country_code'])->formatInternational();

        if (isset($phone['id'])) {

          $phone_exists = Phone::find($phone['id']);

          if (
            $phone_exists &&
            (
              ($phone['number'] !== $phone_exists->number) ||
              ($phone_exists->country_code !== $phone['country_code'])
            )
          ) {

            $phone_exists->update($phone);

          }

          $phoneIds[] = $phone['id'];
        } else {

          $new_phone = new Phone($phone);

          $contact->phones()->save($new_phone);

          $phoneIds[] = $new_phone->id;

        }
      }

      // Remove any phone numbers that are not in $phoneIds.
      $contact->phones()->whereNotIn('id', $phoneIds)->delete();
    }

    if (isset($validated['emails'])) {

      $emailIds = [];

      foreach ($request->emails as $key => $email) {
        if (isset($email['id'])) {
          $email_exists = Email::find($email['id']);

          if ($email_exists && $email['email'] !== $email_exists->email) {
            $email_exists->update($email);
          }

          $emailIds[] = $email['id'];
        } else {

          $new_email = new Email($email);
          $contact->emails()->save($new_email);

          $emailIds[] = $new_email->id;
        }
      }

      $contact->emails()->whereNotIn('id', $emailIds)->delete();
    }

    if (isset($validated['office'])) {

      if ($validated['office']['id']) {

        $contact->office_id = $validated['office']['id'];
        $contact->save();

      }

      $officeData = array_intersect_key(
        $validated['office'], array_flip(['url', 'slogan'])
      );

      $contact->office()->updateOrCreate(
        ['id' => $validated['office']['id']], $officeData
      );

    }

    if (isset($validated['office']['address'])) {

      $address = $validated['office']['address'][0];

      $contact->office->address()->updateOrCreate(
        ['id' => $address['id']], $address
      );

    }

    $title = [
      'Great!',
      'Awesome',
      'That\'s about right!'
    ][rand(0, 2)];

    return redirect(route('contacts.show', $contact->cid))
      ->with('toast', [
        'type' => $title,
        'message' => 'Contact was updated successfully!'
      ]);
  }
}
