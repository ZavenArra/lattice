<?

Class Controller_Language extends Controller {

	public function changeLanguage($language, $redirectObjectId = NULL){

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
}
