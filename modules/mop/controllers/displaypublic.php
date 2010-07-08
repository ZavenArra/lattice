<?
/*
 * Class: DisplayPublic_Controller
 * Basic option for a display controller for the public side of a site.
 * See Display_Controller for full documentation of methods and variables
 */
class DisplayPublic_Controller extends Display_Controller{

	protected $modules = array(
											'publicheader',
											'publicfooter',
										);
	protected $template = 'publicpage';


	public function __construct(){
		parent::__construct();


	}

}


?>
