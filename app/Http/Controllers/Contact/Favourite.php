<?php

namespace App\Http\Controllers\Contact;

use App\Http\Controllers\Controller;
use App\Models\Contact;

class Favourite extends Controller
{
  public function __invoke($ids)
  {
    $idsArray = explode(',', $ids);

    // Contact::whereIn('cid', $idsArray)->update([
    //   'is_favorite' => True
    // ]);

    // Get the current values of is_favorite for the specified IDs
    $currentFavorites = Contact::whereIn('cid', $idsArray)->pluck('is_favorite', 'cid');

    foreach ($currentFavorites as $cid => $isFavorite) {
      Contact::where('cid', $cid)->update([
        'is_favorite' => !$isFavorite,
      ]);
    }

    return redirect()->route('contacts.index', ['filter' => 'favourites']);
  }
}
