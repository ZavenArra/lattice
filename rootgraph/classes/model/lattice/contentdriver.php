<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of contentdriver
 *
 * @author deepwinter1
 */
abstract class Model_Lattice_ContentDriver {
   
   protected $contenttable;
   
   abstract public function loadContentTable($object);

   abstract public function getTitle($object);
   abstract public function setTitle($object, $title);

   
   abstract public function getContentColumn($object, $column);

   abstract public function setContentColumn($object, $column, $value);
   
   abstract public function saveContentTable($object, $inserting=false);
   
  }
   

