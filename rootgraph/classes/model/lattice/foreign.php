<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Model_Lattice_Foreign
 *
 * @author deepwinter1
 */
abstract class Model_Lattice_Foreign extends Model_Lattice_ContentDriver {
   
   protected $contenttable;

   abstract public function foreignTableName();
   
   public function loadContentTable($object) {
      $this->contenttable = ORM::Factory(inflector::singular($this->foreignTableName()));
      $this->contenttable->where('object_id', '=', $object->id)->find();
     
      if(!$this->contenttable->loaded()){
         /* 
       * 
       * 
       * We allow empty objects, so we must allow empty contenttable
       * 
       * 
       *
     
         throw new Kohana_Exception('Failed to load content table :tablename for object :id',
                 array(
                     ':tablename'=>$this->foreignTableName(),
                 ":id"=>$object->id));
        */
      
         $this->contenttable = ORM::Factory(inflector::singular($this->foreignTableName())); 
       }
     
   }
/*
   abstract public function getTitle();

   abstract public function setTitle();
*/
   public function getContentColumn($object, $column) {
      return $this->contenttable->$column;
   }

   public function setContentColumn($object, $column, $value) {
      $this->contenttable->$column = $value;
   }

   public function saveContentTable($object, $inserting) {
      if($inserting){
         $this->contenttable->object_id = $object->id;
      }
      
      $this->contenttable->save();
     // die('saved foregih'.$this->foreignTableName());
   }

}

