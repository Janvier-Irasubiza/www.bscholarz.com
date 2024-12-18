<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Remind extends Mailable
{
    use Queueable, SerializesModels;

    public $url;
    public $app;
    public $client;

    /**
     * Create a new message instance.
     *
     * @param string $url
     * @param string $app
     * @param string $client
     */
    public function __construct($url, $app, $client)
    {
        $this->url = $url;
        $this->app = $app;
        $this->client = $client;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject("{$this -> app} - Payment Reminder")
                    ->markdown('emails.remind') // Using a Markdown template
                    ->with([
                        'url' => $this->url,
                        'app' => $this->app,
                        'client' => $this->client,
                    ]);
    }
}
