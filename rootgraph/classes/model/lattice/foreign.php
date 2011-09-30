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
abstract class Model_Lattice_Foreign extends Model_Object {
   
   protected $contenttable;

   abstract protected function foreignTableName();
   
   protected function loadContentTable() {
      $this->contenttable = ORM::Factory(inflector::singular($this->foreignTableName()));
      $this->contenttable->where('object_id', '=', $this->id)->find();
      if(!$this->contenttable->loaded()){
         throw new Kohana_Exception('Failed to load content table :tablename for object :id',
                 array(
                     ':tablename'=>$this->foreignTableName(),
                 ":id"=>$this->id));
      }
      print_r($this->contenttable);
   }
/*
   abstract protected function getTitle();

   abstract protected function setTitle();
*/
   protected function getContentColumn($column) {
      return $this->contenttable->$column;
   }

   protected function setContentColumn($column, $value) {
      $this->contenttable->$column = $value;
   }

   protected function saveContentTable($inserting) {
      $this->contenttable->save();
   }

}

