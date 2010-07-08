<?
class MOP_HTTP_Errors {
  	public function __construct() {
		Event::add('system.403', array($this, 'show_404'));
		Event::replace('system.404', array('Kohana', 'show_404'), array($this, 'show_404'));
		// etc
	}

	public function show_403() {
		header('HTTP/1.1 403 Forbidden');
		Kohana::$instance = new MOP_Controller;
		Kohana::$instance->template = new View('403');
		// other manipulations
		Kohana::$instance->toWebpage();
		die();
		Kohana::$instance->template->render(TRUE);
		die();
	}

	public function show_404() {
		header('HTTP/1.1 404 File Not Found');
		$error = new Error_Controller('404');
		$error->toWebpage();
		die();
	}

}
new MOP_HTTP_Errors;

