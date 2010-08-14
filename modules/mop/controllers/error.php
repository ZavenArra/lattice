<?

/*
 * Class: Error_Controller
 * Simple controller for displaying an error, unsure if this is used or should be supported 
 * in the future
 */
Class Error_Controller extends MOP_Controller_Core {

	public function __construct($template){
		$this->template = new View($template);
		parent::__construct();
	}

	public function toWebpage(){
		parent::toWebpage();
	}
}
