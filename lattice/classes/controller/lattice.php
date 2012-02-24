<?

class Controller_Lattice extends Controller {

	public static $topController;

	public $resources = array(
		'js'=>array(),
		'libraryjs'=>array(),
		'css'=>array(),
		'librarycss'=>array(),
	);

	public $controllerName;


	//constructor
	public function __construct($request, $response){
		parent::__construct($request, $response);

    try {
      ORM::Factory('object')->find_all();
    } catch(Exception $e){
      $view = new View('latticeNotInstalled');
      echo $view->render();
      die();
    }



		//set the language requirements
		
		$languageCode = NULL;
		if( ! Session::instance()->get('languageCode') ){
			$languageCode = Kohana::config('lattice.defaultLanguage');
			Session::instance()->set('languageCode', $languageCode );
		}else{
			$languageCode = Session::instance()->get('languageCode');
		}
		if(!$languageCode){
			throw new Kohana_Exception('No language code found');
		}
		i18n::lang( $languageCode );


		$this->controllerName = strtolower(substr(get_class($this), 11));
		$this->checkAccess();

		if($request->is_initial()){
		 self::$topController = $this;
    }
		//look up all matching js and css based off controller name

		$this->loadResources();

	}

	/*
	 * Function: checkAccess()
	 * Default function for acccess checking for a controller.  Can be overridden in child classes
	 * Checks logged in user against authrole array in config file for controller
	 * Parameters:nothing, except config file
	 * Returns: nothing
	 */
	public function checkAccess(){
		//Authentication check
		$roles = Kohana::config(strtolower($this->controllerName).'.authrole', FALSE, FALSE);

		//checked if logged in
		if($roles && !Auth::instance()->logged_in()){
			Request::current()->redirect(url::site('auth/login/',Request::current()->protocol(),false).'/'.Request::initial()->uri());
			exit;
		}

		if(is_array($roles)){
			$accessGranted = false;
			foreach($roles as $aRole){
				if($aRole=='admin'){
					if(Kohana::config('lattice.staging_enabled') && !Kohana::config('lattice.staging')){
						$redirect = 'staging/'. Router::$current_uri;
						Request::current()->redirect(url::site($redirect,Request::current()->protocol(),false));
					}
				}

				if(latticeutil::checkRoleAccess($aRole)){
					$accessGranted = true;
				}
			}
		} else {
			if($roles=='admin'){
				if(Kohana::config('lattice.staging_enabled') && !Kohana::config('lattice.staging')){
					$redirect = 'staging/'. Router::$current_uri;
					Request::current()->redirect(url::site($redirect,Request::current()->protocol(),false));
				}
			}

			$accessGranted = latticeutil::checkRoleAccess($roles);
		}

		if(!$accessGranted){
			$redirect = 'accessdenied';
			Request::current()->redirect(url::site($redirect,Request::current()->protocol(),false));
			exit;
		}

	}

	protected function loadResources(){
		$this->loadResourcesForKey(strtolower($this->controllerName));

		$parents = array_reverse($this->getParents());
		foreach($parents as $parent){
			if(strpos($parent, 'Controller')===0){
				$parentKey = substr($parent, 11);
			} else {
				$parentKey = $parent;
			}
			$this->loadResourcesForKey(strtolower($parentKey));
		}	
	}

  protected function loadResourcesForKey($key){
    if(self::$topController == NULL){
      return;
      //self::$topController should not be NULL, in order to use loadResourcesForKey you must extend Controller_Lattice in the controller of your initial route 
    }

		//should add to self, then merge into topController
		if($css = Kohana::find_file('resources', 'css/'.$key, 'css')){
			$this->resources['css'][$css] = lattice::convertFullPathToWebPath($css);
		}
		if($js = Kohana::find_file('resources', 'js/'.$key, 'js')){
			$this->resources['js'][$js] = lattice::convertFullPathToWebPath($js);
		}

		$config = Kohana::config($key);
		//look up all matching js and css configured in the config file
		if(is_array(Kohana::config($key.'.resources') ) ){
			foreach(Kohana::config($key.'.resources') as $key => $paths){
				foreach($paths as $path){
					$this->resources[$key][$path] = $path;
				}
			}
		}

		//and merge into the top controller
		if($this != self::$topController){
			foreach(array_keys($this->resources) as $key){
				self::$topController->resources[$key] = array_merge(self::$topController->resources[$key], $this->resources[$key]);
			}
		}

	}

	public function getParents($class=null, $plist=array()) {
		$class = $class ? $class : $this;
		$parent = get_parent_class($class);
		if($parent) {
			$plist[] = $parent;
			/*Do not use $this. Use 'self' here instead, or you
			 *        * will get an infinite loop. */
			$plist = self::getParents($parent, $plist);
		}
		return $plist;
	}


}
