<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of latticefrontend
 *
 * @author deepwinter1
 */
class latticefrontend {

   public static function createView($objectidorslug){
      
      
      if(!is_object($objectidorslug)){
         $object = Graph::object($objectidorslug);
      } else {
         $object = $objectidorslug;
      }
		//some access control
		$viewName = null;
      $view = null;
		if ($object->loaded()) {
			if ($object->published == false || $object->activity != null) {
				throw new Kohana_User_Exception('Page not availabled', 'The object with identifier ' . $id . ' is does not exist or is not available');
			}
			//look for the objectType, if it's not there just print out all the data raw
			$viewName = $object->objecttype->objecttypename;
			if (file_exists('application/views/frontend/' . $viewName . '.php')) {
				$viewPath = 'frontend/'.$viewName;
			} else if(file_exists('application/views/generated/' . $viewName . '.php')) {
				$viewPath = 'generated/'.$viewName;
			} else {
				$viewPath = 'default';
			}
			$view = new View($viewPath);
		} else {
			//check for a virtual object specified in frontend.xml
			//a virtual object will be one that does not match a objectType
			$viewName = $objectidorslug;
			$view = new View('frontend/'.$viewName);
		}

		//call this->view load data
		//get all the data for the object
		$viewContent = lattice::getViewContent($viewName, $object);
		foreach ($viewContent as $key => $value) {
			$view->$key = $value;
		}
      
      return $view;
   }
     
}
 
