<?
/*
 *
 * This class simulates the views directory, to allow loading of dynamic js while
 * maintaining semantic directory structure in URL
 */

Class Controller_Views extends Controller {

	public function action_js($filename){
		$view = new View('js/'.$filename);	

		$this->response->headers('Content-Type', 'application/x-javascript');
		$this->response->body($view->render());

	}
}
