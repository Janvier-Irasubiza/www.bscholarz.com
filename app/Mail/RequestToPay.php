<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RequestToPay extends Mailable
{
    use Queueable, SerializesModels;

  	public $client;
  	public $app;
  	public $date;
  	public $amount;
  	
    /**
     * Create a new message instance.
     */
    public function __construct($client, $app, $date, $amount)
    {
      	$this->client = $client;
      	$this->app = $app;
      	$this->date = $date;
      	$this->amount = $amount;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Payment Reminder for service: ' . $this->app
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.request_to_pay',
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
