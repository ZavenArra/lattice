<?php

Class Initializer_Lattice {

  public function initialize()
  {
    try {
      Graph::object();
    } catch (Exception $e)
    {
      if ($e->get_code() == 1146)
      { //code for table doesn't exist
        $sql_file = Kohana::find_file('sql', 'lattice', $ext = 'sql');
        $sql = file_get_contents($sql_file);
        mysql_multiquery($sql); 
      }
    }

    $problems=0;
    if (! (file_exists('application/media') AND is_writable('application/media')))
    {
      Lattice_Initializer::add_problem('application/media must exist and be writable.  Use mkdir application/media; chmod 777 application/media'); 
      $problems++;
    }
    if (! (file_exists('application/export') AND is_writable('application/export')))
    {
      Lattice_Initializer::add_problem('application/export must exist and be writable.  Use mkdir application/export; chmod 777 application/export'); 
      $problems++;
    }
    return $problems;
  }

}
