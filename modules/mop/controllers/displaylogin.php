<?
/*
 * Class: DisplayLogin_Controller
 * Basic option for a display controller for the login area of a site.
 * See Display_Controller for full documentation of methods and variables
 */


class DisplayLogin_Controller extends Display_Controller{

	protected $modules = array(
											'publicheader',
											'publicfooter',
										);
	protected $template = 'loginpage';


	public function __construct(){
		parent::__construct();

	}

}


?>
