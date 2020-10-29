<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TestResult extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, $lesson)
    {
        $this->name = $name;
        $this->lesson = $lesson;
    }

    public $name;
    public $lesson;

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject(_('Påminnelse om tidsattestering'))->view('emails.testresult');
    }
}
