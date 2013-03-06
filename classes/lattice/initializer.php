<?php

Class Lattice_Initializer {

  protected static $messages = array();
  protected static $problems = array(); //not yet implemented

  public static function check($dependencies)
  {

    if (!$dependencies)
    {
      return;
    }

    try {
      ORM::Factory('initializedmodule');
    } catch (Exception $e)
    {
      if ($e->get_code() == 1146)
      { //code for table doesn't exist
        //install the initializedmodules table
        $sql_file = Kohana::find_file('sql', 'initializedmodules', $ext = 'sql');
        $sql = file_get_contents($sql_file);
        mysql_query($sql);
      }
    }

    try {
      foreach ($dependencies as $dependency)
      {
        $check = ORM::factory('initializedmodule')
          ->where('module', '=', $dependency)
          ->find();
        if (!$check->loaded() OR $check->status != 'INITIALIZED')
        {

          if (Kohana::find_file('classes/initializer', $dependency))
          {
            try {
              $initializer_class = 'initializer_' . $dependency;
              $initializer = new $initializer_class();
              $problems = $initializer->initialize();
            } catch (Exception $e)
            {
              throw $e;
            }
            if (count($problems) == 0)
            {
              if (!$check->loaded())
              {
                $check = ORM::Factory('initializedmodule');
              }
              $check->module = $dependency;
              $check->status = 'INITIALIZED';
              $check->save();
            }
          } else {
            if (!$check->loaded())
            {
              $check = ORM::Factory('initializedmodule');
            }
            $check->module = $dependency;
            $check->status = 'INITIALIZED';
            $check->save();
          }
        }
      } 
    } 
    catch(Exception $e)
    {
      self::$problems[] = $e->get_message() . Kohana_Exception::text($e);
    }

    if (!count(self::$problems) AND count(self::$messages))
    {
      $view = new View('initialization_messages');
      $view->problems = self::$problems;
      $view->messages = self::$messages;
      echo $view->render();
    } else if (count(self::$problems) OR count(self::$messages))
    {
      $view = new View('initializationproblems');
      $view->problems = self::$problems;
      $view->messages = self::$messages;
      echo $view->render();
    }
    if (count(self::$problems))
    {
      return false;
    } else {
      return true;
    }
  }

  public static function reinitialize($module)
  {
    $check = ORM::factory('initializedmodule')
      ->where('module', '=', $module)
      ->find();
    $check->status = 'NOTINITIALIZED';
    $check->save();
    $all_problems = self::check(array($module));

    if (count($all_problems) OR count(self::$messages))
    {
      $view = new View('initializationproblems');
      $view->problems = $all_problems;
      $view->messages = self::$messages;
      echo $view->render();
      exit;
    }
  }


  public static function add_problem($message)
  {
    self::$problems[] = $message;

  }


  public static function add_message($message)
  {
    self::$messages[] = $message;

  }

}
