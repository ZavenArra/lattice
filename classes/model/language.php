<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of language
 *
 * @author deepwinter1
 */
class Model_Language extends ORM {


  public function __construct($id=NULL)
  {

    if (!empty($id) AND is_string($id) AND !ctype_digit($id))
    {
      $result = DB::select('id')->from('languages')->where('code', '=', $id)->execute()->current();
      $id = $result['id'];
    }

    parent::__construct($id);
  }

}
?>
