<?

/*
 * Class: Error_Controller
 * Simple controller for displaying an error, unsure if this is used or should be supported 
 * in the future
 */
Class Error_Controller extends MOP_Controller_Core {

	public function __construct($template){
		$this->view = new View($template);
		parent::__construct();
	}

	public function toWebpage($custom=null){
		parent::toWebpage($custom);
	}
}
