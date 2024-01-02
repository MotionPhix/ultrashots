<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class Ads extends Mailable
{
  use Queueable, SerializesModels;

  /**
   * Create a new message instance.
   */
  public function __construct(
    public string $mail_subject,
    public string $message,
    public User $user
  ){}

  /**
   * Get the message envelope.
   */
  public function envelope(): Envelope
  {
    return new Envelope(
      subject: $this->mail_subject,
    );
  }

  /**
   * Get the message content definition.
   */
  public function content(): Content
  {
    return new Content(
      markdown: 'mail.ads',
    );
  }

  /**
   * Get the attachments for the message.
   *
   * @return array<int, \Illuminate\Mail\Mailables\Attachment>
   */
  public function attachments(): array
  {
    /*if (isset($this->pdf)) {
      // Attachment::fromStorage('/path/to/file'),
      return [
        // Attachment::fromPath($this->path)->as('name.pdf')
        //   ->withMime('application/pdf'),

        Attachment::fromData(fn () => $this->pdf, 'Report.pdf')
          ->withMime('application/pdf'),
      ];
    }*/

    return [];
  }
}
