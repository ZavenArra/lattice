<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
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
      $this->attributes['templateFilter'] = null;
      $this->attributes['where'] = null;
      $this->attributes['from'] = null;

      foreach($attributes as $key=>$value){
         $this->attributes[$key] = $value;
      }
   }
   
   public function initWithXml($xml) {
      $this->attributes['label'] = $xml->getAttribute('label');
      $this->attributes['templateFilter'] = $xml->getAttribute('filter');
      $this->attributes['where'] = $xml->getAttribute('where');
      $this->attributes['from'] = $xml->getAttribute('from');
   }
   
   public function run(){
          
     $objects = Graph::object();

      //apply optional parent filter
      if ($from = $this->attributes['from']) { //
         if ($from == 'parent') {
            $objects->where('parentId', '=', $parentId);
         } else {
            $from = Graph::object($from);
            $objects->where('parentId', '=', $from->id);
         }
      }

      //apply optional template filter
      $objects = $objects->templateFilter($this->attributes['templateFilter']); 

      //apply optional SQL where filter
      if ($where = $this->attributes['where']) { //
         $objects->where($where);
      }


      $objects->publishedFilter();
      $objects->order_by('sortorder');
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
