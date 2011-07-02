<?

Class testlighthouse_Controller extends Controller {
	public function newticket(){
		lighthouse::newTicket('test title', 'test description ');
		echo 'done';
	}

	public function newTicketWithTags(){
		lighthouse::newTicket('test title', 'test description', array('tag'=>'billinginquiry'));
		echo 'done';
	}
}
