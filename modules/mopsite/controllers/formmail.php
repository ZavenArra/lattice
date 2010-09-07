<?
Class FormMail_Controller extends Controller {
	public function send(){
		try{
			$content = null;
			$name = $_POST['name'];
			$email = $_POST['email'];
			$subject =  Kohana::config('formmail.subject') . $_POST['subject'];
			$message = $_POST['message'];			
			$content = "name: " . $name . "\nemail: " . $email . "\n\nmessage:\n" . $message;
			mail( Kohana::config('formmail.email'), $subject, $content, "From: ".Kohana::config('formmail.fromLine').":\nReply-To: $email\n"); 
			$result = array( 'success'=>true, 'message'=>"Your message has been sent. We will be in touch as soon as possible. Thank you." );
		}
		catch( Exception $e ){
			$result = array( 'error'=>true, 'message'=>"There was a problem submitting the form, please try again later." );			
		}
		echo json_encode( $result );
	}
}
