<?

/*
 * Class: MsieLanding_Controller
 * Displays a landing page for unsupported browsers
 */

Class MsieLanding_Controller extends Controller {

	public function index() {
		$view = new View('msielanding');
		$view->render(true);
	}
}
