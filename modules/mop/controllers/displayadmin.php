<?
/*
 * Class: DisplayAdmin_Controller
 * Basic option for a display controller for the admin side of a site.
 * See Display_Controller for full documentation of methods and variables
 */

class DisplayAdmin_Controller extends Display_Controller{

	protected $modules = array(
										'adminheader',
										'mop_auth',
										'adminfooter',
										);
	protected $template = 'adminpage';


	public function __construct(){
		parent::__construct();

	}

}


?>
