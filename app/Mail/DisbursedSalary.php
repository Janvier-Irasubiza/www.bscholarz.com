<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DisbursedSalary extends Mailable
{
    use Queueable, SerializesModels;

  	public $staff_names;  	
  	public $amount_disbursed;  	
  	public $balance;
  	public $phone_number;


  	
    /**
     * Create a new message instance.
     */
    public function __construct($staff_names, $amount_disbursed, $balance, $phone_number)
    {
      	$this->staff_names = $staff_names;
      	$this->amount_disbursed = $amount_disbursed;
      	$this->balance = $balance;      	
      	$this->phone_number = $phone_number;

    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'You Have Been Paid!',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.disbursed',
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
