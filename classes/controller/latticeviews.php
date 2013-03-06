<?php
/*
 * Class: Site_Controller
 * Responsible for handing default behaviour of CMS driven sites,
 * using slugs or ids to navigate between objects.  Works hand in
 * hand with the slugs hook
 */
Class Controller_Lattice_views extends Controller_Layout{

  protected $_actions_that_get_layout = array(
    'get_view',
  );

  public static $slug;

  /*
   * Variable: $content
   * Holds the content for a object
   */
  protected $content = array();

  public function __construct($request, $response)
  {
    parent::__construct($request, $response);
  }

  /*
   * Function: after
   * Calculate layout wrapping for slug
   * Setting latticeviews.layouts.$slug to a layout name will load slug within that layout
   * if there is no view file available for that name, no wrapping occurs
   */
  public function after()
  {
    if ($this->request == Request::initial() )
    {
      $layout_for_slug = Kohana::config('latticeviews.layouts.'.self::$slug);
      $object = Graph::object(self::$slug);
      $layout_for_object_type = Kohana::config('latticeviews.layouts_for_object_type.'.$object->objecttypename);
      if ($layout_for_slug)
      {
        if (Kohana::find_file('views/', $layout_for_slug))
        {
          $this->wrap_with_layout($layout_for_slug); 
        }
      } elseif ($layout_for_object_type)
      {
        if (Kohana::find_file('views/', $layout_for_object_type))
        {
          $this->wrap_with_layout($layout_for_object_type); 
        }
      } else {
        parent::after();
      }

    }
  }

  /*
   * Function: index
   * Wrapper to object that uses the controller as the slug
   */
  public function action_index()
  {
    $this->action_object(substr(get_class($this), 0, -11));
  }


  /*
   * Function: object($object_id_or_slug)
   * By default called after a rewrite of routing by slugs hooks, gets all content
   * for an object and loads view
   * Parameters:
   * $object_id_or_slug - the id or slug of the object to display, NULL is allowed but causes exception
   * Returns: nothing, renders full webobject to browser or sents html if AJAX request
   */

  public function action_get_view($object_id_or_slug=NULL)
  {

    $access = Kohana::config('latticeviews.access.'.$object_id_or_slug);
    if ( ! latticeutil::check_access($access))
    {
      Request::current()->redirect(url::site('auth/login/',Request::current()->protocol(),FALSE).'/'.Request::initial()->uri());
    }

    self::$slug = $object_id_or_slug;

    if (Session::instance()->get('language_code'))
    {
      $object = Graph::object($object_id_or_slug);
      if ( ! $object->loaded())
      {
        if ( ! $object_id_or_slug)
        {
          $object_id_or_slug = 'No object id or slug specified';
        }
        throw new Kohana_Exception('No object found for id: '.$object_id_or_slug);
      }
      $translated_object = $object->translate(Session::instance()->get('language_code'));
      $object_id_or_slug = $translated_object->id;
    }

    $this->view_model = latticeview::Factory($object_id_or_slug);

    // possible hook for processing content	

    $this->response->body($this->view_model->view()->render());
    $this->response->data($this->view_model->data());


  }


  public function action_get_virtual_view($view_name)
  {

    $this->view = new latticeview($view_name);

    // possible hook for processing content	

    $this->response->body($this->view->render());

  }



}
