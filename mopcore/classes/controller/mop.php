<?

class Controller_MOP extends Controller {

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
		$role = Kohana::config(strtolower($this->controllerName).'.authrole', FALSE, FALSE);

		//checked if logged in
		if($role && !Auth::instance()->logged_in($role)){
			Request::current()->redirect(url::site('auth/login/',Request::current()->protocol(),false).'/'.Request::initial()->uri());
			exit;
		}

		if(is_array($role)){
			$accessGranted = false;
			foreach($role as $aRole){
				if($role=='admin'){
					if(Kohana::config('mop.staging_enabled') && !Kohana::config('mop.staging')){
						$redirect = 'staging/'. Router::$current_uri;
						Request::current()->redirect(url::site($redirect,Request::current()->protocol(),false));
					}
				}

				if(moputil::checkRoleAccess($aRole)){
					$accessGranted = true;
				}
			}
		} else {
			if($role=='admin'){
				if(Kohana::config('mop.staging_enabled') && !Kohana::config('mop.staging')){
					$redirect = 'staging/'. Router::$current_uri;
					Request::current()->redirect(url::site($redirect,Request::current()->protocol(),false));
				}
			}

			$accessGranted = moputil::checkRoleAccess($role);
		}

		if(!$accessGranted){
			$redirect = 'accessdenied';
			Request::current()->redirect(url::site($redirect,Request::current()->protocol(),false));
			exit;
		}

	}

	protected function loadResources(){
		$this->loadResourcesForKey($this->controllerName);

		$parents = array_reverse($this->getParents());
		foreach($parents as $parent){
			if(strpos($parent, 'Controller')===0){
				$parentKey = substr($parent, 11);
			} else {
				$parentKey = $parent;
			}
			$this->loadResourcesForKey($parentKey);
		}	
	}

	protected function loadResourcesForKey($key){

		 $key = strtolower($key);

		//should add to self, then merge into topController
		if($css = Kohana::find_file('views', 'css/'.$key, 'css')){
			$this->resources['css'][$css] = helper_mop::convertFullPathToWebPath($css);
		}
		if($js = Kohana::find_file('views', 'js/'.$key, 'js')){
			$this->resources['js'][$js] = helper_mop::convertFullPathToWebPath($js);
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
