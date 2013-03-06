<?php defined('SYSPATH') or die('No direct script access.');
/* @package Lattice */

class Response extends Kohana_Response {

  protected $_data;

  public function data($value=NULL)
  {
    if ($value)
    {
      $this->_data = $value;
    }	
    return $this->_data;

  }


}
