<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendVerificationCode extends Mailable
{
    use Queueable, SerializesModels;

    use Queueable, SerializesModels;

    public $user;
    public $code;

    public function __construct($user, $code)
    {
        $this->user = $user;
        $this->code = $code;
    }

    public function build()
    {
        return $this->markdown('emails.verify')
                    ->with([
                        'user' => $this->user,
                        'code' => $this->code,
                    ]);
    }

    /**
     * Build the message.
     *
     * @return $this
     */

}
