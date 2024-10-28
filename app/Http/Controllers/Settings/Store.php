<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Account\AccountRequest;
use App\Models\Account;
use App\Models\User;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class Store extends Controller
{
  public function __invoke(AccountRequest $request)
  {
    $validated = $request->validated();

    $account = Account::create($validated);

    if ($request->hasFile('logo')) {

      $file = $request->file('logo');

      $avatar_path = $request->file('logo')->store('', 'logos');

      $account->logo()->create([
        'path' => $avatar_path,
        'name' => $file->hashName(),
      ]);

    }

    return redirect()->back();
  }
}
