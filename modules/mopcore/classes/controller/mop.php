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


		if($request->is_initial()){
		 self::$topController = $this;
		}

		//look up all matching js and css based off controller name
		$this->controllerName = strtolower(substr(get_class($this), 11)); 
		
		$this->loadResources($this->controllerName);
	}

	protected function loadResources($key){
		if(is_subclass_of(self::$topController, 'Controller_MOP')){	
			//should add to self, then merge into topController
			if($css = Kohana::find_file('views', 'css/'.$key, 'css')){
				$this->resources['css'][$css] = helper_mop::convertFullPathToWebPath($css);
			}
			if($js = Kohana::find_file('views', 'js/'.$key, 'js')){
				$this->resources['js'][$js] = helper_mop::convertFullPathToWebPath($js);
			}
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

}
