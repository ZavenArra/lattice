<?
/**
* Class: Navigation_Controller 
*
*
*/

class Navigation {

	
	/*
		Function:loadNode
		Utility function to get one node
	*/
	public static function loadNode(& $item){
		$sendItem = array();
		foreach($this->navDataFields_page as $send=>$field){
			$sendItem[$send] = $item->$field;
		}
		foreach($this->navDataFields_template as $field){
			$sendItem[$field] = $item->template->$field;
		}
		if(!count($sendItem['addableObjects'])){
			unset($sendItem['addableObjects']);
		}

		
		if(!is_object($item->contenttable)){
			throw new Kohana_Exception('No content table for object:' . 'template: ' . $item->template->templatename . ' table: '.$item->template->contenttable);
		}
		foreach($this->navDataFields_content as $send=>$field){
			$sendItem[$send] = $item->contenttable->$field;
		}
		
      
		if(!$sendItem['title']){
			$sendItem['title'] = $sendItem['slug'];
		}

		return $sendItem;
	}
		
}

?>
