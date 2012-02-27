<?php

/*
 * To change this objectType, choose Tools | Templates
 * and open the objectType in the editor.
 */

/**
 * Description of
 *
 * @author deepwinter1
 */
class Model_Lattice extends ORM {

  public function getRelationships(){
    if(!$this->loaded()){
      throw new Kohana_Exception('Model is not loaded');
    }

    $relationships = ORM::Factory('objectrelationship')
      ->where('lattice_id', '=', $this->id)
      ->order_by('sortorder', 'DESC')
      ->find_all();

    return $relationships;

  }
}

