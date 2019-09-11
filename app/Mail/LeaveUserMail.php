<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class LeaveUserMail extends Mailable
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
		$dd_email = $this->data['dd_email'];
		$ee_email = $this->data['ee_email'];
        $leave_type = $this->data['leave_type'];
        $date_from = $this->data['date_from'];
        $date_to = $this->data['date_to'];       
        $day_off = $this->data['day_off'];
        $unit = $this->data['unit'];
		
		if(!empty($cc_email) && !empty($dd_email) && !empty($ee_email)){
			if($cc_email == $my_email){
				return $this->view('mails.leave_user_message',[
					'my_name'=>$my_name,
					'man_name'=>$man_name,
					'leave_type'=>$leave_type,
					'date_from'=>$date_from,
					'date_to'=>$date_to,
					'day_off'=>$day_off,
					'unit'=>$unit,
					])
					->from($my_email, $my_name)
					->to($man_email)
					->cc($cc_email)		
					->subject('A Message from Leave Management System');
			}
			
			if($dd_email == $my_email){
				return $this->view('mails.leave_user_message',[
					'my_name'=>$my_name,
					'man_name'=>$man_name,
					'leave_type'=>$leave_type,
					'date_from'=>$date_from,
					'date_to'=>$date_to,
					'day_off'=>$day_off,
					'unit'=>$unit,
					])
					->from($my_email, $my_name)
					->to($man_email)
					->cc($dd_email)		
					->subject('A Message from Leave Management System');
			}
			
			if($ee_email == $my_email){
				return $this->view('mails.leave_user_message',[
					'my_name'=>$my_name,
					'man_name'=>$man_name,
					'leave_type'=>$leave_type,
					'date_from'=>$date_from,
					'date_to'=>$date_to,
					'day_off'=>$day_off,
					'unit'=>$unit,
					])
					->from($my_email, $my_name)
					->to($man_email)
					->cc($ee_email)		
					->subject('A Message from Leave Management System');
			}
		}else{
			return $this->view('mails.leave_user_message',[
				'my_name'=>$my_name,
				'man_name'=>$man_name,
				'leave_type'=>$leave_type,
				'date_from'=>$date_from,
				'date_to'=>$date_to,
				'day_off'=>$day_off,
				'unit'=>$unit,
				])
				->from($my_email, $my_name)
				->to($man_email)
				->subject('A Message from Leave Management System');
		}
    }
}
