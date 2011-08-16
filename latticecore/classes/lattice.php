<?

    class MyDOMDocument {
      public $_delegate;
      private $_validationErrors;

      public function __construct (DOMDocument $pDocument) {
        $this->_delegate = $pDocument;
        $this->_validationErrors = array();
      }

      public function __call ($pMethodName, $pArgs) {
        if ($pMethodName == "validate") {
          $eh = set_error_handler(array($this, "onValidateError"));
          $rv = $this->_delegate->validate();
          if ($eh) {
            set_error_handler($eh);
          }
          return $rv;
        }
        else {
          return call_user_func_array(array($this->_delegate, $pMethodName), $pArgs);
        }
      }
      public function __get ($pMemberName) {
        if ($pMemberName == "errors") {
          return $this->_validationErrors;
        }
        else {
          return $this->_delegate->$pMemberName;
        }
      }
      public function __set ($pMemberName, $pValue) {
        $this->_delegate->$pMemberName = $pValue;
      }
      public function onValidateError ($pNo, $pString, $pFile = null, $pLine = null, $pContext = null) {
        $this->_validationErrors[] = preg_replace("/^.+: */", "", $pString).$pLine;
      }
    }
    
    
Class lattice {

	private static $config;


	public static function config($arena, $xpath, $contextNode=null){
		if(!is_array(self::$config)){
			self::$config = array();
		}

		if($activeConfig = Kohana::config('lattice.activeConfiguration')){
			if($configurations = Kohana::config('lattice.configurations')){
				if($active = $configurations[$activeConfig]){
					if(isset($active[$arena]) && $newName = $active[$arena]){
						$arena = $newName;
					}
				}
			}
		}



		if(!isset(self::$config[$arena])){

			$dom = new DOMDocument();
			$dom->preserveWhiteSpace = false;
			$dom = new MyDOMDocument($dom);

			//check for arena mappings
			if($customName = Kohana::config('lattice.filenames.'.$arena)){
				$arena = $customName;
			}

			if(file_exists($arena)){
				//if the argument is actually a path to a file
				$path = getcwd().'/'.$arena;
			} else {
				$path = Kohana::find_file('config', $arena, 'xml', true); 
				$path = $path[count($path)-1];
			}
			if(!count($path)){
				throw new Kohana_Exception('Could not locate xml :file', array(':file'=>$arena));
			}

			$dom->load( $path );
			if(!$dom->validate()){
				echo('Validation failed on '.$path[0]);
				print_r($dom->errors);
				die();
			}

			if($arena == 'objects'){
				$clusters = new DOMDocument();
				$clusters = new MYDOMDocument($clusters);
				$path = Kohana::find_file('config', 'clusters', 'xml', true);
				if(!count($path)){
					throw new Kohana_Exception('Could not locate xml clusters');
				}
				$clusters->load( $path[0] );
				//echo $clusters->_delegate->saveXML();
				$clusters = new DOMXPath($clusters->_delegate);
				$clusterNodes = $clusters->evaluate('//objectType');
				foreach($clusterNodes as $node){
					$node = $dom->_delegate->importNode($node, true);
					$objectTypesNode = $dom->_delegate->getElementsByTagName('objectTypes')->item(0);
					$objectTypesNode->appendChild($node);
					//$dom->_delegate->insertBefore($node, $refNode);
				}
				//recreate Xpath object
				//$dom->formatOutput;
				//echo $dom->_delegate->saveXML();
			}

			$xpathObject = new DOMXPath($dom->_delegate);


			self::$config[$arena] = $xpathObject;
		}
		if($contextNode){
			$xmlNodes = self::$config[$arena]->evaluate($xpath, $contextNode);
		} else {
			$xmlNodes = self::$config[$arena]->evaluate($xpath);
		}
		return $xmlNodes;
	}

	/*
	 * Function: buildModule
	 This is the same function as in Display_Controller..
	 Obviously these classes should share a parent class or this is a static helper
	 Parameters:
	 $module - module configuration parameters
	 $constructorArguments - module arguments to constructor
	 */
	public static function buildModule($module, $constructorArguments=array() ){
		//need to look into this, these should be converged or interoperable
		if(isset($module['elementname'])){
			$module['modulename'] = $module['elementname'];
		}

		if(!Kohana::find_file('controllers', $module['modulename'] ) ){
			if(!isset($module['controllertype'])){
				$view = new View($module['modulename']);
				$object = ORM::Factory('object')->where('slug', '=', $module['modulename'])->find();
				if($object->loaded()){ // in this case it's a slug for a specific object
					foreach(lattice::getViewContent($object->id, $object->objecttype->objecttypename) as $key=>$content){
						$view->$key = $content;
					}
				}
				return $view->render();
			}
      try {
        if(!class_exists($module['modulename'].'_Controller')){
          $includeclass = 'class '.$module['modulename'].'_Controller extends '.$module['controllertype'].'_Controller { } ';
          eval($includeclass);
        }
      } catch (Exception $e){
        throw new Kohana_User_Exception('Redeclared Virtual Class', 'Redeclared Virtual Class '.  'class '.$module['modulename'].'_Controller ');
      }
		}

		$fullname = $module['modulename'].'_Controller';
		$module = new $fullname; //this needs to be called with fargs
		call_user_func_array(array($module, '__construct'), $constructorArguments);

		$module->createIndexView();
		$module->view->loadResources();

		//and load resources for it's possible parents
		$parentclass = get_parent_class($module);
		$parentname = str_replace('_Controller', '', $parentclass);
		$module->view->loadResources(strtolower($parentname));

		//build submodules of this module (if any)
		$module->buildModules();

		return $module->view->render();

		//render some html
		//
		//BELOW HERE NEEDS TO BE FIXED IN ALL CHILDREN OF Lattice_CONTROLLER
		//CONTROLERS SHOULD JUST ASSIGN TEMPLATE VARS THEN AND THERE
		if($objectTypevar==NULL){
			$this->view->$module['modulename'] = $module->view->render();
		} else {
			$this->view->$objectTypevar = $module->view->render();
		}
	}

	public static function getViewContent($view, $slug=null) {

		$data = array();

		if ($view == 'default') {
			$object = ORM::Factory('object')->where('slug', '=', $slug)->find();
			if (!$object->loaded()) {
				throw new Koahan_Exception('lattice::getViewContent : Default view callled with no slug');
			}
			$data['content']['main'] = $object->getPageContent();
			return $data;
		}

		$viewConfig = lattice::config('frontend', "//view[@name=\"$view\"]")->item(0);
		if (!$viewConfig) {
         throw new Kohana_Exception("No View setup in frontend.xml by that name: $view");
		}
		if ($viewConfig->getAttribute('loadPage')) {
			$object = ORM::Factory('object')->where('slug', '=', $slug)->find();
			if (!$object->loaded()) {
				throw new Kohana_Exception('lattice::getViewContent : View specifies loadPage but no object to load');
			}
			$data['content']['main'] = $object->getPageContent();
		}

		$includeContent = lattice::getIncludeContent($viewConfig, $object->id);
		foreach ($includeContent as $key => $values) {
			$data['content'][$key] = $values;
		}

		if ($subViews = lattice::config('frontend', "subView", $viewConfig)) {
			foreach ($subViews as $subview) {
				$view = $subview->getAttribute('view');
				$slug = $subview->getAttribute('slug');
				$label = $subview->getAttribute('label');
				if (lattice::config('frontend', "//view[@name=\"$view\"]")) {

					if ($view && $slug) {
						$subViewContent = lattice::getViewContent($view, $slug);
					} else if ($slug) {
						$object = ORM::Factory('object')->where('slug', '=', $slug)->find();
						$view = $object->objecttype->objecttypename;
						$subViewContent = lattice::getViewContent($view, $slug);
					} else if ($view) {
						$subViewContent = lattice::getViewContent($view);
					} else {
						die("subview $label must have either view or slug");
					}
					$subView = new View($view);

					foreach ($subViewContent as $key => $content) {
						$subView->$key = $content;
					}
					$data[$label] = $subView->render();
				} else {
					//assume it's a module
					$data[$label] = lattice::buildModule(array('modulename' => $view/* , 'controllertype'=>'object' */), $subview->getAttribute('label'));
				}
			}
		}

		return $data;
	}

	public static function getIncludeContent($includeTier, $parentId){
    $content = array();
    if($includeContentQueries = lattice::config('frontend', 'includeData', $includeTier)) {
         foreach ($includeContentQueries as $includeContentQueryParams) {
            $query = new Graph_ObjectQuery();
            $query->initWithXml($includeContentQueryParams);
            $includeContent = $query->run($parentId);

            for ($i = 0; $i < count($includeContent); $i++) {
               $children = lattice::getIncludeContent($includeContentQueryParams, $includeContent[$i]['id']);
               $includeContent[$i] = array_merge($includeContent[$i], $children);
            }
            $content[$query->attributes['label']] = $includeContent;
         }
    }
    return $content;
  }

	//takes Exception as argument
	public static function getOneLineErrorReport(Exception $e){
		switch(get_class($e)){
			case 'Lattice_ApiException':
				return $e->getOneLineErrorReport();
				break;
			default:
				$message = $e->getMessage();
				foreach( $e->getTrace() as $trace){
					if(isset($trace['file'])){
						$message .= " ::::: ".$trace['file'].':'.$trace['line']."\n;";
					}
				}
				return $message;
				break;
		}
	}	
  
	public static $webRoot = null;

	public static function convertFullPathToWebPath($fullPath){


		if(self::$webRoot == null){
			self::$webRoot  = getcwd().'/';
		}
		$webpath = str_replace(self::$webRoot, '', $fullPath);
		
		return $webpath;
	}


}



