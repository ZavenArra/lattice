<?

class Controller_MOP extends Controller {

	public static $topController;

	public $resources = array(
		'js'=>array(),
		'libraryjs'=>array(),
		'css'=>array(),
		'librarycss'=>array(),
	);


	//constructor
	public function __construct($request, $response){
		parent::__construct($request, $response);	

		//global skinning could happen here, with lookup for replacement files
		//in subdirectories

		if($request->is_initial()){
		 self::$topController = $this;
		}

		//look up all matching js and css based off controller name
		$controllerName = strtolower(substr(get_class($this), 11)); 
		if(is_subclass_of(self::$topController, 'Controller_MOP')){	
			//should add to self, then merge into topController
			if($css = Kohana::find_file('views', 'css/'.$controllerName, 'css')){
				$this->resources['css'][$css] = $css;
			}
			if($js = Kohana::find_file('views', 'js/'.$controllerName, 'js')){
				$this->resources['js'][$js] = $js;
			}
		}

		$config = Kohana::config($controllerName);
		//look up all matching js and css configured in the config file
		foreach(Kohana::config($controllerName.'.resources') as $key => $paths){
			foreach($paths as $path){
				$this->resources[$key][$path] = $path;
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
