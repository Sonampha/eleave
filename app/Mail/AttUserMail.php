<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AttUserMail extends Mailable
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
        $my_name = $this->data['my_name'];
        $man_name = $this->data['man_name'];
        $my_email = $this->data['my_email'];
        $man_email = $this->data['man_email'];
		$cc_email = $this->data['cc_email'];
        $att_status = $this->data['att_status'];
        $att_date = $this->data['att_date'];
		
		if(!empty($cc_email)){
			return $this->view('mails.att_user_message',[
				'my_name'=>$my_name,
				'man_name'=>$man_name,
				'att_status'=>$att_status,
				'att_date'=>$att_date,
				])
				->from($my_email, $my_name)
				->to($man_email)
				->cc($cc_email)
				->subject('A Message from Leave Management System');
		}else{
			return $this->view('mails.att_user_message',[
				'my_name'=>$my_name,
				'man_name'=>$man_name,
				'att_status'=>$att_status,
				'att_date'=>$att_date,
				])
				->from($my_email, $my_name)
				->to($man_email)
				->subject('A Message from Leave Management System');
		}


    }
}
