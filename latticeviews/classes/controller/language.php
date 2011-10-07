<?

Class Controller_Language extends Controller {

	public function action_changeLanguage($language, $redirectObjectId = NULL){

			$session = Session::instance();
			$session->set('language', $language);
	
			if($redirectObjectId){
				//process redirect, with new language
				$object = Graph::object($redirectObjectId);
				$translatedObject = $object->translate($redirectObjectId);
				$redirectSlug = $translatedObject->slug;
				url::redirect($redirectSlug);
			}
	}


	public function action_languageControls(){
		$languages = Graph::languages();
		$view = new View('languageControls');
		$view->languages = $languages;
		$this->response->body($view->render());
	}
}
