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
abstract class Model_Lattice_Contentdriver {

  protected $contenttable;

  abstract public function load_content_table($object);

  abstract public function get_title($object);
  abstract public function set_title($object, $title);


  abstract public function get_content_column($object, $column);

  abstract public function set_content_column($object, $column, $value);

  abstract public function save_content_table($object, $inserting=FALSE);

  abstract public function delete();

  /*
   * Returns info about the driver.
   */
  public function driver_info()
  {
    return array(
      'driver'=>'mysql',
      'table_name'=>$this->contenttable,
    );
  }

}


