<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AttTaskMail extends Mailable
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
        $man_name = $this->data['man_name'];
        $staff_name = $this->data['staff_name'];
        $man_email = $this->data['man_email'];
        $staff_email = $this->data['staff_email'];

        return $this->view('mails.att_task_message',[
            'man_name'=>$man_name,
            'staff_name'=>$staff_name,
            ])
            ->from($man_email, $man_name)
            ->to($staff_email)
            ->subject('A Message from Leave Management System');
    }
}
