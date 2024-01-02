<?php

namespace App\Http\Controllers\Contact;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class Favourite extends Controller
{
  public function __invoke($ids)
  {
    $idsArray = explode(',', $ids);

    Contact::whereIn('cid', $idsArray)->update([
      'is_favorite' => True
    ]);

    return redirect()->route('contacts.index', [ 'filter' => 'favourites' ]);
  }
}
