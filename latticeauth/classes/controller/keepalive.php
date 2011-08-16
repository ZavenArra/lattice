<?

class KeepAlive_Controller extends Controller {

	public function index(){
		if(Auth::instance()->logged_in()){
			echo 'true';
		} else {
			echo 'false';
		}
	}
}
