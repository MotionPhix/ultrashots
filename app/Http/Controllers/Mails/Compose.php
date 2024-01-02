<?php

namespace App\Http\Controllers\Mails;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Inertia\Inertia;

class Compose extends Controller
{
  public function __invoke()
  {
    return Inertia::render('Emails/Form');
  }
}
