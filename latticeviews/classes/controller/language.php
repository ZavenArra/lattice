<?

Class Controller_Language extends Controller {

	public function setLanguage($language, $redirect = NULL){

			$session = Session::instance();
			$session->set('language', $language);
	
			if($redirect){
				//process redirect, with new language
			}
	}
}
