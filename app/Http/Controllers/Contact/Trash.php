<?php

namespace App\Http\Controllers\Contact;

use App\Http\Controllers\Controller;
use App\Models\Contact;

class Trash extends Controller
{

  public function __invoke($ids)
  {
    $idsArray = explode(',', $ids);

    Contact::whereIn('cid', $idsArray)->delete();

    return redirect()->route('contacts.index');
  }

}
