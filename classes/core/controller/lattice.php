<?php

class Core_Controller_Lattice extends Controller {

  public static $top_controller;

  public $resources = array(
    'js'=>array(),
    'libraryjs'=>array(),
    'css'=>array(),
    'librarycss'=>array(),
  );

  public $controller_name;


  // constructor
  public function __construct($request, $response)
  {
    parent::__construct($request, $response);

    // set the language requirements

    $language_code = NULL;
    if ( ! Session::instance()->get('language_code') )
    {
      $language_code = Kohana::config('lattice.default_language');
      Session::instance()->set('language_code', $language_code );
    }else{
      $language_code = Session::instance()->get('language_code');
    }
    if ( ! $language_code)
    {
      throw new Kohana_Exception('No language code found');
    }
    i18n::lang( $language_code );


    $this->controller_name = strtolower(substr(get_class($this), 11));
    $this->check_access();

    if ($request->is_initial())
    {
      self::$top_controller = $this;
    }
    // look up all matching js and css based off controller name

    $this->load_resources();

  }

  /*
   * Function: check_access()
   * Default function for acccess checking for a controller.  Can be overridden in child classes
   * Checks logged in user against authrole array in config file for controller
   * Parameters:nothing, except config file
   * Returns: nothing
   */
  public function check_access()
  {
    // Authentication check
    $roles = Kohana::config(strtolower($this->controller_name).'.authrole', FALSE, FALSE);

    // checked if logged in
    if ($roles AND ! Auth::instance()->logged_in())
    {
      Request::current()->redirect(url::site('auth/login/',Request::current()->protocol(),FALSE).'/'.Request::initial()->uri());
      exit;
    }
    if (is_array($roles))
    {
      $access_granted = FALSE;
      foreach ($roles as $a_role)
      {
        if ($a_role=='admin')
        {
          if (Kohana::config('lattice.staging_enabled') AND ! Kohana::config('lattice.staging'))
          {
            $redirect = 'staging/'. Router::$current_uri;
            Request::current()->redirect(url::site($redirect,Request::current()->protocol(),FALSE));
          }
        }

        if (cms_util::check_role_access($a_role))
        {
          $access_granted = TRUE;
        }
      }
    } else {
      if ($roles=='admin')
      {
        if (Kohana::config('lattice.staging_enabled') AND ! Kohana::config('lattice.staging'))
        {
          $redirect = 'staging/'. Router::$current_uri;
          Request::current()->redirect(url::site($redirect,Request::current()->protocol(),FALSE));
        }
      }

      $access_granted = cms_util::check_role_access($roles);
    }

    if ( ! $access_granted)
    {
      $redirect = 'accessdenied';
      Request::current()->redirect(url::site($redirect,Request::current()->protocol(),FALSE));
      exit;
    }

  }

  protected function load_resources()
  {
    $this->load_resources_for_key(strtolower($this->controller_name));

    $parents = array_reverse($this->get_parents());
    foreach ($parents as $parent)
    {
      if (strpos($parent, 'Controller')===0)
      {
        $parent_key = substr($parent, 11);
      } else {
        $parent_key = $parent;
      }
      $this->load_resources_for_key(strtolower($parent_key));
    }	
  }

  protected function load_resources_for_key($key)
  {

    //  	Kohana::$log->add( Kohana_Log::INFO, "application/config/lattice_cms.php " . print_r( $config['resources']['libraryjs'], 1 ) );

    if (self::$top_controller == NULL)
    {
      return;
      // self::$top_controller should not be NULL, in order to use load_resources_for_key you must extend Core_Controller_Lattice in the controller of your initial route 
    }

    // should add to self, then merge into top_controller
    if ($css = Kohana::find_file('resources', 'css/'.$key, 'css'))
    {
      $this->resources['css'][$css] = core_lattice::convert_full_path_to_web_path($css);
    }
    if ($js = Kohana::find_file('resources', 'js/'.$key, 'js'))
    {
      $this->resources['js'][$js] = core_lattice::convert_full_path_to_web_path($js);
    }

    $config = Kohana::config($key);
    // look up all matching js and css configured in the config file
    if ( is_array(Kohana::config($key.'.resources') ) )
    {
      foreach (Kohana::config($key.'.resources') as $key => $paths)
      {
        foreach ($paths as $path)
        {
          $this->resources[$key][$path] = $path;
        }
      }
    }

    // and merge into the top controller
    if ($this != self::$top_controller)
    {
      foreach (array_keys($this->resources) as $key)
      {
        self::$top_controller->resources[$key] = array_merge(self::$top_controller->resources[$key], $this->resources[$key]);
      }
    }

  }

  public function get_parents($class=NULL, $plist=array())
  {
    $class = $class ? $class : $this;
    $parent = get_parent_class($class);
    if ($parent)
    {
      $plist[] = $parent;
      /*Do not use $this. Use 'self' here instead, or you
       *        * will get an infinite loop. */
      $plist = self::get_parents($parent, $plist);
    }
    return $plist;
  }


}
