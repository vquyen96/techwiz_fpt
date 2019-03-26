<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class MailTemplate extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    private $data;
    private $mailInfo;

    public function __construct($data, $mailInfo)
    {
        $this->data = $data;
        $this->mailInfo = $mailInfo;
    }

    public function build()
    {
        $address = $this->mailInfo['address'];
        $name = $this->mailInfo['name'];
        $subject = $this->mailInfo['subject'];
        $renderView = $this->mailInfo['view'];
        
        return $this->view($renderView)
                ->from($address, $name)
                ->subject($subject)
                ->with($this->data);
    }
}
