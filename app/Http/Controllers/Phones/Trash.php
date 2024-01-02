<?php

namespace App\Http\Controllers\Phones;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\Phone;
use ProtoneMedia\Splade\Facades\Toast;

class Trash extends Controller
{
  public function __invoke(Contact $contact, Phone $phone)
  {
    $contact->load('phones');

    // Delete the matched phone number
    $contact->phones()->where('id', $phone->id)->delete();

    Toast::title('That\'s it!')
      ->info($contact->first_name . '`s phone was deleted')
      ->leftBottom()
      ->autoDismiss(5);

    return redirect()->back();
  }
}
