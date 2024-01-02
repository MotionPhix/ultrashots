<?php

namespace App\Http\Controllers\Contact;

use App\Http\Controllers\Controller;
use App\Models\Contact;

class Restore extends Controller
{

  public function __invoke($ids)
  {
    $idsArray = explode(',', $ids);

    Contact::whereIn('cid', $idsArray)->restore();

    return redirect()->back();
  }
}
