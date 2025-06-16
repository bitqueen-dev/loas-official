<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Reminder extends Mailable{
	use Queueable, SerializesModels;

	public function __construct($mailBody, $attPath){
		$this->mailBody = $mailBody;
		$this->attPath = $attPath;
	}

	public function build(){
		if($this->attPath) {
			return $this->view('emails.reminder')
			->from('officialsite@loas.jp', 'loa2 service mail')
			->subject("【" . $this->mailBody['subject'] . $this->mailBody['userId'] . "】")
			->with(['infos' => $this->mailBody])
			->attach($this->attPath);
		} else {
			return $this->view('emails.reminder')
			->from('officialsite@loas.jp', 'loa2 service mail')
			->subject("【" . $this->mailBody['subject'] . $this->mailBody['userId'] . "】")
			->with(['infos' => $this->mailBody]);
		}
	}
}