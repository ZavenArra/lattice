<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


/**
 * Description of latticeviews
 *
 * @author deepwinter1
 */

class latticeview {
   
   private static $initialObject = NULL;

	 private $data;
	 private $view;
	 protected $object;

	 public static function Factory($objectIdOrSlug){

			$object = self::getGraphObject($objectIdOrSlug);
			$objectTypeName = $object->objecttype->objecttypename;
			if(Kohana::find_file('classes', 'viewmodel/'.$objectTypeName)){
				$className = 'ViewModel_'.$objectTypeName;
				$viewModel = new $className($objectIdOrSlug);
			} else {
				$viewModel = new latticeview($objectIdOrSlug);
			}
			return $viewModel;
	 }

	 /*
		* slug($slug)
		* Gets the a language aware slug based on the requested slug
		*/
	 public static function slug($slugOrObjectId){

		 //look in the cache
		 $languageCode = Session::instance()->get('languageCode');
		 if(!$languageCode){
			return $slugOrObjectId;
		 }
		 $object = Graph::object($slugOrObjectId);
		 $originalSlugBase = str_replace(array('0','1','2','3','4','5','6','7','8','9'), '', strtok($object->slug,'_'));
		 $translatedObject = $object->translate($languageCode);
		 $redirectSlug = $translatedObject->slug;


		 if(preg_match("/{$originalSlugBase}[0-9]+/", $redirectSlug)){
			 return $originalSlugBase.'_'.$languageCode;
		 } else {	
			 return $redirectSlug;
		 }

	 }

	 /*
		* public static function language()
		* Returns the currently selected language code
		*/
	 public static function language(){
		 return Session::instance()->get('languageCode');
	 }

	 public function __construct($objectIdOrSlug = null){
		 if($objectIdOrSlug != NULL){
			 $this->object = self::getGraphObject($objectIdOrSlug);
		 }
		 $this->createView($objectIdOrSlug);
	 }

	 public function data(){
			return $this->data;
	 }

	 public function view(){
			return $this->view;
	 }

	 private static function getGraphObject($objectIdOrSlug){
		 if(!is_object($objectIdOrSlug)){
			 $object = Graph::object($objectIdOrSlug);
		 } else {
			 $object = $objectIdOrSlug;
		 }
		 if(!$object->loaded()){
			 throw new Kohana_Exception("Trying to create view, but object is not loaded: $objectIdOrSlug ".$object->slug);
		 }
		 return $object;

	 }

	 public function setVar($name, $value){
		if(!$this->view){
			throw new Kohana_Exception('setVar called but no local variable view has not been set');
		}

		$this->view->$name = $value;
		$this->data[$name] = $value;
	 }

   public function createView($objectIdOrSlug = null){

		 if($objectIdOrSlug){
			$this->object = $this->getGraphObject($objectIdOrSlug);
		 }

		 if(!self::$initialObject){
			 self::$initialObject = $this->object;
		 }

		 //some access control
		 $viewName = null;
		 $view = null;

		 /*
			* This logic needs to be cleaned up.  Does it really make sense to be calling
			* lattice view model for views that have no object?  Virtual views - these items can also
			* have view content, and could have view models, but no object
			*/
		 if ($this->object->loaded()) {
			 if ($this->object->activity != null) {
				 throw new Kohana_User_Exception('Page not availabled', 'The object with identifier ' . $id . ' is does not exist or is not available');
			 }
			 //look for the objectType, if it's not there just print out all the data raw
			 $viewName = $this->object->objecttype->objecttypename;
			 if (file_exists('application/views/frontend/' . $viewName . '.php')) {
				 $viewPath = 'frontend/'.$viewName;
			 } else if(file_exists('application/views/generated/' . $viewName . '.php')) {
				 $viewPath = 'generated/'.$viewName;
			 } else {
				 $viewPath = 'default';
			 }
			 $view = new View($viewPath);
		 }
	 
		//call this->view load data
		//get all the data for the object
		$viewContent = $this->getViewContent($viewName, $this->object);

		$this->data = $viewContent;

		foreach ($viewContent as $key => $value) {
			$view->$key = $value;
		}
      
		$this->view = $view;

   }
   
   /*
    * Returns the first object that was sent to createView
    */
   public static function initialObject() {
      return self::$initialObject;
   }


	 public function createVirtualView($viewName){

			//check for a virtual object specified in frontend.xml
			//a virtual object will be one that does not match a objectType

			if (file_exists('application/views/frontend/' . $viewName . '.php')) {
				$viewPath = 'frontend/'.$viewName;
			} else if(file_exists('application/views/generated/' . $viewName . '.php')) {
				$viewPath = 'generated/'.$viewName;
			} else {
				$viewPath = 'default';
			}
			$view = new View($viewPath);

		//call this->view load data
		//get all the data for the object
		$viewContent = $this->getViewContent($viewName);
		foreach ($viewContent as $key => $value) {
			$view->$key = $value;
		}
      
      return $view;

	 }
 
	public function getViewContent($view, $slug=null) {

		if((!$view || $view=='') && (!$slug || $slug=='')){
			throw new Kohana_Exception('getViewContent called with null parameters');
		}

		$data = array();

		$object = null;
		$object_id = null;
		if  ($slug) {

			if (!is_object($slug)) {
				$object = Graph::object($slug);
			} else {
				$object = $slug;
			}
		}
		if($object){
			$object_id = $object->id;
		}

		if ($view == 'default') {
			if (!$object->loaded()) {
				throw new Koahan_Exception('latticeviews::getViewContent : Default view callled with no slug');
			}
			$data['content']['main'] = $object->getPageContent();
			return $data;
		}

		$viewConfig = lattice::config('frontend', "//view[@name=\"$view\"]")->item(0);
		if (!$viewConfig) {
        // throw new Kohana_Exception("No View setup in frontend.xml by that name: $view");
			// we are allowing this so that objects automatically can have basic views
		}
		$loaded =  $object->loaded();
		if ($slug) {
			if($object->loaded() != 1) {
				throw new Kohana_Exception('latticeviews::getViewContent : view called with slug: :slug, but no object to load',
					array(
						':slug'=>$slug,
					)
				);
			}
		}
		if($object && $viewConfig && $viewConfig->getAttribute('loadPage')){
			$data['content']['main'] = $object->getPageContent();
		}

		$includeContent = $this->getIncludeContent($viewConfig, $object_id);
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
						$subViewContent = $this->getViewContent($view, $slug);
					} else if ($slug) {
						$object = Graph::object($slug);
						$view = $object->objecttype->objecttypename;
						$subViewContent = $this->getViewContent($view, $slug);
					} else if ($view) {
						$subViewContent = $this->getViewContent($view);
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

	public function getIncludeContent($includeTier, $parentId){
    $content = array();
    if($includeContentQueries = lattice::config('frontend', 'includeData', $includeTier)) {
         foreach ($includeContentQueries as $includeContentQueryParams) {
            $query = new Graph_ObjectQuery();
            $query->initWithXml($includeContentQueryParams);
            $includeContent = $query->run($parentId);

            for ($i = 0; $i < count($includeContent); $i++) {
               $children = $this->getIncludeContent($includeContentQueryParams, $includeContent[$i]['id']);
               $includeContent[$i] = array_merge($includeContent[$i], $children);
            }
            $content[$query->attributes['label']] = $includeContent;
         }
    }
    return $content;
  }

    
}
 
