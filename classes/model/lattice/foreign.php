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
abstract class Model_Lattice_Foreign extends Model_Lattice_Content_driver {
   
   protected $contenttable;

   abstract public function foreign_table_name();
   
   public function load_content_table($object) {
      $this->contenttable = ORM::Factory(inflector::singular($this->foreign_table_name()));
      $this->contenttable->where('object_id', '=', $object->id)->find();
     
      if (!$this->contenttable->loaded()){
         /* 
       * 
       * 
       * We allow empty objects, so we must allow empty contenttable
       * 
       * 
       *
     
         throw new Kohana_Exception('Failed to load content table :tablename for object :id',
                 array(
                     ':tablename'=>$this->foreign_table_name(),
                 ":id"=>$object->id));
        */
      
         $this->contenttable = ORM::Factory(inflector::singular($this->foreign_table_name())); 
       }
     
   }
/*
   abstract public function get_title();

   abstract public function set_title();
*/
   public function get_content_column($object, $column) {
      return $this->contenttable->$column;
   }

   public function set_content_column($object, $column, $value) {
      $this->contenttable->$column = $value;
   }

   public function save_content_table($object, $inserting=FALSE) {
      if ($inserting){
         $this->contenttable = ORM::Factory(inflector::singular($this->foreign_table_name()));
         $this->contenttable->object_id = $object->id;
      }
      
      $this->contenttable->save();
   }

}

