<?php
/* @package Lattice */

class MyDOMDocument {
  public $_delegate;
  private $_validation_errors;

  public function __construct (DOMDocument $p_document)
  {
    $this->_delegate = $p_document;
    $this->_validation_errors = array();
  }

  public function __call ($p_method_name, $p_args)
  {
    if ($p_method_name == "validate")
    {
      $eh = set_error_handler(array($this, "on_validate_error"));
      $rv = $this->_delegate->validate();
      if ($eh)
      {
        set_error_handler($eh);
      }
      return $rv;
    }
    else {
      return call_user_func_array(array($this->_delegate, $p_method_name), $p_args);
    }
  }
  public function __get ($p_member_name)
  {
    if ($p_member_name == "errors")
    {
      return $this->_validation_errors;
    }
    else {
      return $this->_delegate->$p_member_name;
    }
  }
  public function __set ($p_member_name, $p_value)
  {
    $this->_delegate->$p_member_name = $p_value;
  }
  public function on_validate_error ($p_no, $p_string, $p_file = NULL, $p_line = NULL, $p_context = NULL)
  {
    $this->_validation_errors[] = preg_replace("/^.+: */", "", $p_string).$p_line;
  }
}


Class lattice {

  private static $config;


  public static function config($arena, $xpath, $context_node=NULL)
  {
    if (!is_array(self::$config))
    {
      self::$config = array();
    }

    if ($active_config = Kohana::config('lattice.active_configuration'))
    {
      if ($configurations = Kohana::config('lattice.configurations'))
      {
        if ($active = $configurations[$active_config])
        {
          if (isset($active[$arena]) AND $new_name = $active[$arena])
          {
            $arena = $new_name;
          }
        }
      }
    }



    if (!isset(self::$config[$arena]))
    {

      $dom = new DOMDocument();
      $dom->preserve_white_space = FALSE;
      $dom = new MyDOMDocument($dom);

      // check for arena mappings
      if ($custom_path = Kohana::config('lattice.paths.'.$arena))
      {
        $arena_path = $custom_path;
      } else {
        $arena_path = $arena;
      }


      $request = NULL;
      $response = NULL;
      try{
        $request = Request::Factory($arena_path);
        $response = $request->execute();

      } catch(Exception $e)
      {
        // checking for existence of xml controller
        if (get_class($e) != 'HTTP_Exception_404')
        {
          throw $e;
        }
        // else continue on
      }

      if ($response)
      {
        $dom->loadXML($response->body());

      } else {

        if (file_exists($arena_path))
        {
          // if the argument is actually a path to a file
          $arena_path = getcwd() . '/' . $arena_path;
        } else {
          $arena_file_path = Kohana::find_file('lattice', $arena_path, 'xml', TRUE);
          if (!count($arena_file_path))
          {
            throw new Kohana_Exception('Could not locate xml :file', array(':file' => $arena_path));
          }
          $arena_path = $arena_file_path[count($arena_file_path) - 1];
        }
        $dom->load($arena_path);
      }
      if (!$dom->validate())
      {
        throw new Kohana_Exception("Validation failed on :arena_path \n :xml_error_trace", array(
          ':arena_path' => $arena_path,
          ':xml_error_trace' =>  var_export($dom->errors, TRUE)
        ));
      }

      if ($arena == 'objects')
      {
        $clusters = new DOMDocument();
        $clusters = new MYDOMDocument($clusters);
        $path = Kohana::find_file('lattice', 'clusters', 'xml', TRUE);
        if (!count($path))
        {
          throw new Kohana_Exception('Could not locate xml clusters');
        }
        $clusters->load( $path[0] );
        // echo $clusters->_delegate->saveXML();
        $clusters = new DOMXPath($clusters->_delegate);
        $cluster_nodes = $clusters->evaluate('// object_type');
        foreach ($cluster_nodes as $node)
        {
          $node = $dom->_delegate->import_node($node, TRUE);
          $object_types_node = $dom->_delegate->get_elements_by_tag_name('object_types')->item(0);
          $object_types_node->append_child($node);
          // $dom->_delegate->insert_before($node, $ref_node);
        }
        // recreate Xpath object
        // $dom->format_output;
        // echo $dom->_delegate->saveXML();
      }

      $xpath_object = new DOMXPath($dom->_delegate);


      self::$config[$arena] = $xpath_object;
    }
    if ($context_node)
    {
      $xml_nodes = self::$config[$arena]->evaluate($xpath, $context_node);
    } else {
      $xml_nodes = self::$config[$arena]->evaluate($xpath);
    }
    return $xml_nodes;
  }

  /*
   * Function: build_module
   This is the same function as in Display_Controller..
   Obviously these classes should share a parent class or this is a static helper
   Parameters:
   $module - module configuration parameters
   $constructor_arguments - module arguments to constructor
   */
  public static function build_module($module, $constructor_arguments=array() )
  {
    // need to look into this, these should be converged or interoperable
    if (isset($module['elementname']))
    {
      $module['modulename'] = $module['elementname'];
    }

    if (!Kohana::find_file('controllers', $module['modulename'] ) )
    {
      if (!isset($module['controllertype']))
      {
        $view = new View($module['modulename']);
        $object = Graph::object($module['modulename']);
        if ($object->loaded())
        { //  in this case it's a slug for a specific object
          foreach (latticeviews::get_view_content($object->id, $object->objecttype->objecttypename) as $key=>$content)
          {
            $view->$key = $content;
          }
        }
        return $view->render();
      }
      try {
        if (!class_exists($module['modulename'].'_Controller'))
        {
          $includeclass = 'class '.$module['modulename'].'_Controller extends '.$module['controllertype'].'_Controller { } ';
          eval($includeclass);
        }
      } catch (Exception $e)
        {
          throw new Kohana_User_Exception('Redeclared Virtual Class', 'Redeclared Virtual Class '.  'class '.$module['modulename'].'_Controller ');
        }
    }

    $fullname = $module['modulename'].'_Controller';
    $module = new $fullname; // this needs to be called with fargs
    call_user_func_array(array($module, '__construct'), $constructor_arguments);

    $module->create_index_view();
    $module->view->load_resources();

    // and load resources for it's possible parents
    $parentclass = get_parent_class($module);
    $parentname = str_replace('_Controller', '', $parentclass);
    $module->view->load_resources(strtolower($parentname));

    // build submodules of this module (if any)
    $module->build_modules();

    return $module->view->render();

    // render some html
    // 
    // BELOW HERE NEEDS TO BE FIXED IN ALL CHILDREN OF Lattice_CONTROLLER
    // CONTROLERS SHOULD JUST ASSIGN TEMPLATE VARS THEN AND THERE
    if ($object_typevar==NULL)
    {
      $this->view->$module['modulename'] = $module->view->render();
    } else {
      $this->view->$object_typevar = $module->view->render();
    }
  }

  public static function set_current_language($language_code)
  {
    Session::instance()->set('language_code', $language_code);
  }

  public static function get_current_language()
  {
    $language_code = Session::instance()->get('language_code');
    if (!$language_code)
    {
      $language_code = Kohana::config('lattice.default_language');
    }
    return $language_code;
  }

  // takes Exception as argument
  public static function get_one_line_error_report(Exception $e)
  {
    switch(get_class($e))
    {
    case 'Lattice_Api_exception':
      //  echo get_class($e);
      //  die();
      return $e->get_one_line_error_report();
      break;
    default:
      $message = $e->get_message();
      foreach ( $e->get_trace() as $trace)
      {
        if (isset($trace['file']))
        {
          $message .= " ::::: ".$trace['file'].':'.$trace['line']."\n;";
        }
      }
      return $message;
      break;
    }
  }	

  public static $web_root = NULL;

  public static function convert_full_path_to_web_path($full_path)
  {


    if (self::$web_root == NULL)
    {
      self::$web_root  = getcwd().'/';
    }
    $webpath = str_replace(self::$web_root, '', $full_path);

    return $webpath;
  }


}



