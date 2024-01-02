<?php

namespace App\Http\Controllers\Mails;

use App\Http\Controllers\Controller;
use App\Http\Requests\Email\EmailRequest;
use App\Mail\Ads;
use App\Models\Contact;
use Illuminate\Support\Facades\Mail;

class Send extends Controller
{
  public function __invoke(EmailRequest $request, $ids)
  {
    $idsArray = explode(',', $ids);

    /*$emails = [];

    $contacts = Contact::with('emails')
      ->whereIn('cid', $idsArray)
      ->get();

    foreach ($contacts as $contact) {
      foreach ($contact->emails as $email) {
        $emails[] = $email->email;
      }
    };*/

    $emails = Contact::with('emails')
      ->whereIn('cid', $idsArray)
      ->get()
      ->flatMap(function ($contact) {
        return $contact->emails->pluck('email');
      })
      ->toArray();

    foreach ($emails as $recipient) {
      Mail::to($recipient)->queue(
        new Ads(
          mail_subject: $request->subject,
          message: $request->body,
          user: auth()->user(),
        ),
      );
    }

    $title = [
      'Great!',
      'Awesome',
      'That\'s about right!'
    ][rand(0, 2)];

    return redirect()->back()->with('toast', [
      'type' => $title,
      'message' => "Email {{ count($emails) > 1 ? 'were' : 'was' }} sent!"
    ]);
  }
}
