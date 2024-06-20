<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class Postpone extends Mailable
{
    use Queueable, SerializesModels;

  	public $url;
  	public $app;
  	public $client;
  	public $reason;
  	
    /**
     * Create a new message instance.
     */
    public function __construct($url, $client, $app, $reason)
    {
      	$this->url = $url;
      	$this->client = $client;
      	$this->app = $app;
      	$this->reason = $reason;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Request for '. $this->app .' Postponed',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.postponedApp',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
