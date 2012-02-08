<?
Class Controller_Formmail extends Controller_Layout {

	public $_actionsThatGetLayout = array('send');

	public function sendEmail(){
		try{
			$content = null;
			$name = $_POST['name'];
			$email = $_POST['email'];
			$subject =  Kohana::config('formmail.subject');
			$content = "name: " . $name . "\nemail: " . $email . "\n\n";
			foreach(Kohana::config('formmail.fields') as $field){
				$content .= $field.': '.$_POST[$field]."\n\n";
			}

			mail( Kohana::config('formmail.email'), $subject, $content, "From: ".Kohana::config('formmail.fromLine')."\nReply-To: $email\n"); 
			$result = array( 'error'=>false, 'message'=>"Your message has been sent. We will be in touch as soon as possible. Thank you." );
		}
		catch( Exception $e ){
			$result = array( 'error'=>true, 'message'=>"There was a problem submitting the form, please try again later." );			
		}
		return $result;
	}

	public function action_ajaxsend(){
		$result = $this->sendEmail();
		echo json_encode( $result );
	}

	public function action_send(){
		$result = $this->sendEmail();
		$view = new View('formmail/done');
		$view->result = $result;	
		$this->response->body($view->render());

	}
}
