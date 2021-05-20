<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Feedback extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($content, $lesson, $name, $email, $country, $language, $contacted)
    {
        $this->content = $content;
        $this->lesson = $lesson;
        $this->name = $name;
        $this->email = $email;
        $this->country = $country;
        $this->language = $language;
        $this->contacted = $contacted;
    }

    public $content;
    public $lesson;
    public $name;
    public $email;
    public $country;
    public $language;
    public $contacted;

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if($this->email !== null && $this->name !== null) {
            return $this->from($this->email, $this->name)->view('emails.feedback');
        } else {
            return $this->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))->view('emails.feedback');
        }
    }
}
