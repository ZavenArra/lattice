<?php defined('SYSPATH') or die('No direct script access.');

/*
Class: XML_View
Class to provide view variable to xml, html_entity_decode on all vars
*/

class XML_View extends View{

	public function __set($key, $value){
		$value = $this->decode_recurse($value);
		parent::__set($key, $value);
	}

	private function decode_recurse($value){
		//handle object?
		if(!is_array($value)){
			return html_entity_decode($value);
		} else {
			for($i=0, $keys=array_keys($value), $count=count($value); $i<$count; $i++){
				$value[$keys[$i]] = $this->decode_recurse($value[$keys[$i]]);
			}
			return $value;
		}
	}

}
?>
