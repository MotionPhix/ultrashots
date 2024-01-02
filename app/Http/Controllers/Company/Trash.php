<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use ProtoneMedia\Splade\Facades\Toast;

class Trash extends Controller
{
  public function __invoke(Contact $contact)
  {
    $contact->load('company');

    // Delete the company
    $contact->company()->delete();

    Toast::title('Ewew!')
      ->info($contact->first_name . '`s company was deleted')
      ->leftBottom()
      ->autoDismiss(5);

    return redirect()->back();
  }
}
