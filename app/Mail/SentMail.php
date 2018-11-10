<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;


class SentMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $address = 'dfms.sit@gmail.com';
        $subject = 'Welcome to Document Flow Management System';
        $name = 'Document Flow Management System';
        
        if($this->data->email_Type == 'approve'){
            return $this->view('ApproveEmail',['data'=>$this->data])
                        ->from($address, $name)
                        ->cc($address, $name)
                        ->bcc($address, $name)
                        ->replyTo($address, $name)
                        ->subject($subject);
        }

        else if($this->data->email_Type == 'success'){
            return $this->view('SuccessEmail',['data'=>$this->data])
                        ->from($address, $name)
                        ->cc($address, $name)
                        ->bcc($address, $name)
                        ->replyTo($address, $name)
                        ->subject($subject);
        }

        else if($this->data->email_Type == 'reject'){
            return $this->view('RejectEmail',['data'=>$this->data])
                        ->from($address, $name)
                        ->cc($address, $name)
                        ->bcc($address, $name)
                        ->replyTo($address, $name)
                        ->subject($subject);
        }
    }
}
