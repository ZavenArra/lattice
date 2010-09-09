<?php defined('SYSPATH') or die('No direct script access.');

/*
 * Class: DisplayView
 * Subclass of View ( My View ) which renders the overall layout of the webpage, including css and js
 */
class DisplayView extends View{

	public function __construct($name = NULL, $data = NULL, $type = NULL){
		parent::__construct($name, $data, $type);
	}

	/*
	 * Function: render([$output=FALSE])
	 * Assigns resources to view variables, and renders the view
	 * Parameters:
	 * $output - whether or not to return html, defaults to false (render to browser)
	 */
	public function render($output=FALSE){
		Display_Controller::addResources($this->resources);
		//After adding resources, we need to put them into the assigns
		$this->javascript = html::script(Display_Controller::$resources['libraryjs']);
		$this->javascript .= html::script(Display_Controller::$resources['js']);
		$this->javascript .= '<script type="text/javascript">'.Display_Controller::getJSBlock()."</script>\n";
		$this->stylesheet = html::stylesheet(Display_Controller::$resources['librarycss']);
		$this->stylesheet .= html::stylesheet(Display_Controller::$resources['css']);
		return View_Core::render($output);
	}

}
?>
