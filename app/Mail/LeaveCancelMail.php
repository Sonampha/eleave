<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class LeaveCancelMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $data;
    
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
        $staff_name = $this->data['staff_name'];
        $man_name = $this->data['man_name'];
        $staff_email = $this->data['staff_email'];
        $man_email = $this->data['man_email'];        

        return $this->view('mails.leave_cancel_message',[
            'man_name'=>$man_name,
            'staff_name'=>$staff_name,
            ])
            ->from($staff_email, $staff_name)
            ->to($man_email)
            ->subject('A Message from Leave Management System');
    }
}
