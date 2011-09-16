<?php

/*
 * To change this objectType, choose Tools | Templates
 * and open the objectType in the editor.
 */

/**
 * Description of objectquery
 *
 * @author deepwinter1
 */
class Graph_ObjectQuery {

   public $attributes;
   
   
   public function initWithArray($attributes){
      $this->attributes['label'] = null;
      $this->attributes['objectTypeFilter'] = null;
      $this->attributes['where'] = null;
      $this->attributes['from'] = null;
      $this->attributes['slug'] = null;

      foreach($attributes as $key=>$value){
         $this->attributes[$key] = $value;
      }
   }
   
   public function initWithXml($xml) {
      $this->attributes['label'] = $xml->getAttribute('label');
      $this->attributes['objectTypeFilter'] = $xml->getAttribute('objectTypeFilter');
      $this->attributes['where'] = $xml->getAttribute('where');
      $this->attributes['from'] = $xml->getAttribute('from');
      $this->attributes['slug'] = $xml->getAttribute('slug');
   }
   
   public function run($parentId = null){
          
     $objects = Graph::object();

			//apply slug filter
			if($this->attributes['slug']){
				$objects->where('slug', '=', $this->attributes['slug']);
			}

      //apply optional parent filter
      if ($from = $this->attributes['from'] ) { //
				if($from != 'all'){
					if ($from == 'parent') {
						$objects->latticeChildrenFilter($parentId);
					} else {
						$from = Graph::object($from);
						$objects->latticeChildrenFilter($from->id);
					}
				}
      }

      //apply optional objectType filter
      $objects = $objects->objectTypeFilter($this->attributes['objectTypeFilter']); 

      //apply optional SQL where filter
      if ($where = $this->attributes['where']) { //
         $objects->where($where);
      }

	
      $objects->publishedFilter();
      //order_by can be configurable later on
      $objects->order_by('objectrelationships.sortorder');
      $objects = $objects->find_all();
  
      $items = array();
      foreach ($objects as $includeObject) {
         $itemsData = $includeObject->getContent();
         $items[] = $itemsData;
      }
      return $items;
      
   }
}

?>
