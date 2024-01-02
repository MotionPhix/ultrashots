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

    if (isset($validated['addresses'])) {

      $addressIds = [];

      foreach ($request->addresses as $key => $address) {
        if (isset($address['id'])) {
          $address_exists = Address::find($address['id']);

          if ($address_exists) {
            if (
              $address['city'] !== $address_exists->city ||
              $address['state'] !== $address_exists->state ||
              $address['street'] !== $address_exists->street ||
              $address['country'] !== $address_exists->country
            ) {
              $address_exists->update($address);
            }
          }

          $addressIds[] = $address['id'];
        } else {

          $new_address = new Address($address);
          $contact->addresses()->save($new_address);

          $addressIds[] = $new_address->id;
        }
      }

      $contact->addresses()->whereNotIn('id', $addressIds)->delete();
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

    return redirect(route('contacts.show', $contact->cid))
      ->with('toast', [
        'type' => $title,
        'message' => 'Contact was updated successfully!'
      ]);
  }
}
