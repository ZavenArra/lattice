<?
/**
* Class: Navigation_Controller 
*
*
*/

class Navigation {

	
	/*
		Function:getNodeInfo
		Utility function to get one node
	*/
	public static function getNodeInfo(& $object){
		$nodeInfo = array();
		foreach(Kohana::config('navigation.navDataFields.object') as $send=>$field){
			$nodeInfo[$send] = $object->$field;
		}
		foreach(Kohana::config('navigation.navDataFields.objectType') as $field){
			$nodeInfo[$field] = $object->template->$field;
		}
		if(!count($nodeInfo['addableObjects'])){
			unset($nodeInfo['addableObjects']);
		}

		
		if(!is_object($object->contenttable)){
			throw new Kohana_Exception('No content table for object:' . 'template: ' . $object->template->templatename . ' table: '.$object->template->contenttable);
		}
		foreach(Kohana::config('navigation.navDataFields.content') as $send=>$field){
			$nodeInfo[$send] = $object->contenttable->$field;
		}
		
      
		if(!$nodeInfo['title']){
			$nodeInfo['title'] = $nodeInfo['slug'];
		}

		return $nodeInfo;
	}
   
   /*
		Function:getNodeInfo
		Utility function to get one node
	*/
	public static function getNodeInfoById($id){
		$object = Graph::object($id);
      $nodeInfo = Navigation::getNodeInfo($object);
		return $nodeInfo;
	}
		
}

?>
