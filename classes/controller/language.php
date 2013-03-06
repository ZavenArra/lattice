<?

Class Controller_Language extends Controller {

	public function action_change_language($language_code, $redirect_object_id = NULL){

		lattice::set_current_language($language_code);
			if($redirect_object_id){
				//process redirect with new language_code
				//this is actually the latticeview::get_language_aware_slug call
				$this->request->redirect(latticeview::slug($redirect_object_id));
			}
	}


	public function action_language_controls(){
		$languages = Graph::languages();
		$view = new View('language_controls');
		$view->languages = $languages;
		$this->response->body($view->render());
	}
}
