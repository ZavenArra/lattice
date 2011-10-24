<?

Class Controller_AccessDenied extends Controller_Layout {

	public $_actionsThatGetLayout = array('index');

	public function action_index(){
		$view = new View('accessdenied');
		$this->response->body($view->render());
	}

}
