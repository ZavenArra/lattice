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
	public $basename;


	//constructor
	public function __construct($request, $response){
		parent::__construct($request, $response);	

		//global skinning could happen here, with lookup for replacement files
		//in subdirectories

		if($request->is_initial()){
		 self::$topController = $this;
		}

		//look up all matching js and css based off controller name
		$this->controllerName = strtolower(substr(get_class($this), 11)); 
		$this->baseName = Kohana::config($this->controllerName.'.baseName');
		if(!$this->baseName){
			$this->baseName = $this->controllerName;
		}

		if(is_subclass_of(self::$topController, 'Controller_MOP')){	
			//should add to self, then merge into topController
			if($css = Kohana::find_file('views', 'css/'.$this->baseName, 'css')){
				$this->resources['css'][$css] = helper_mop::convertFullPathToWebPath($css);
			}
			if($js = Kohana::find_file('views', 'js/'.$this->baseName, 'js')){
				$this->resources['js'][$js] = helper_mop::convertFullPathToWebPath($js);
			}
		}

		$config = Kohana::config($this->baseName);
		//look up all matching js and css configured in the config file
		if(is_array(Kohana::config($this->baseName.'.resources') ) ){
			foreach(Kohana::config($this->baseName.'.resources') as $key => $paths){
				foreach($paths as $path){
					$this->resources[$key][$path] = $path;
				}
			}
		}

		//and merge into the top controller
		if($this != self::$topController){
			foreach(array_keys($this->resources) as $key){
				self::$topController[$key] = array_merge(self::$topController[$key], $this->resources[$key]);
			}
		}
	}

/*
 * Function: outputLayout
 * Wrap the response in its configured layout
 */
	public function outputLayout(){
		//set layout - read from config file
		$layout = 'LayoutAdmin';	
		$layoutView = View::Factory($layout);
		
		//build js and css
		$stylesheet = '';
		foreach(array_merge($this->resources['css'], $this->resources['librarycss']) as $css){
			$stylesheet .=	HTML::style($css)."\n       ";
		}
		$layoutView->stylesheet = $stylesheet;

		$javascript = '';
		foreach(array_merge($this->resources['js'], $this->resources['libraryjs']) as $js){
			$javascript .= HTML::script($js)."\n        ";		
		}
		$layoutView->javascript = $javascript;

		$layoutView->body = $this->response->body();
		$this->response->body($layoutView->render());
	}
}
