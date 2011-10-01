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
		if(!substr('Lattice_Object', get_class($object))){
			$object = Graph::object($object);
		}

		$nodeInfo = array();
		foreach(Kohana::config('navigation.navDataFields.object') as $send=>$field){
			$nodeInfo[$send] = $object->$field;
		}
		foreach(Kohana::config('navigation.navDataFields.objectType') as $field){
			$nodeInfo[$field] = $object->objecttype->$field;
		}
		if(!count($nodeInfo['addableObjects'])){
			unset($nodeInfo['addableObjects']);
		}

		
		foreach(Kohana::config('navigation.navDataFields.content') as $send=>$field){
			$nodeInfo[$send] = $object->$field;
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
