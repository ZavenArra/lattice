<?

Class Controller_Language extends Controller {

	public function action_changeLanguage($languageCode, $redirectObjectId = NULL){

			$session = Session::instance();
			$session->set('languageCode', $languageCode);
			if($redirectObjectId){
				//process redirect with new languageCode
				//this is actually the latticeview::getLanguageAwareSlug call
				//die(latticeview::slug($redirectObjectId));
				$this->request->redirect(latticeview::slug($redirectObjectId));
			}
	}


	public function action_languageControls(){
		$languages = Graph::languages();
		$view = new View('languageControls');
		$view->languages = $languages;
		$this->response->body($view->render());
	}
}
