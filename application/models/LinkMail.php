<?php
class LinkMail extends CI_Model
{   
    function sendmail($keterangan,$subject,$email,$from,$message,$email_config,$user_id) {
        $this->load->library('email');
        $this->email->initialize($email_config);
		$this->email->set_newline("\r\n");
		$this->email->clear(TRUE);
		$this->email->from($from);
		$this->email->to($email);
		$this->email->subject($subject);
		$this->email->message($message);
        $send   = $this->email->send(TRUE);
		
        if ($send==TRUE) {
            $saveMail  =   array(
                'keterangan'    => $keterangan,
                'subject'       => $subject,
                'to'            => $email,
                'from'          => $from,
                'message'       => $message,
                'user_id'       => $user_id,
            );
            $this->Master->save_data('send_email' , $saveMail);
        }
        return $send;
    }
}
?>
