<?php
/**
 * Class: CMS_Controller
 * The main CMS class, handling add, delete, and retrieval of objects
 * @author Matthew Shultz
 * @package Lattice
 */


class Lattice_CMS extends Lattice_CMSInterface {

  
 protected $_actions_that_get_layout = array(
  'index',
 );


  /*
 *  Variable: object_id
 *  static int the global object id when operating within the CMS submodules get the object id
 *  we could just reference the primary_id attribute of Display as well...
 */
 private static $object_id = NULL;


 /*
  * Variable: unique
  * Used to provide unique ids for radio buttons and other input elements
  */
 private static $unique = 1;

 /*
  Variable: model
  The main data model for content stored by this module
 */
 private $model = 'object';

 /*
 *
 * Variable: modules
 * Build the cms's included modules
 *
 */

 protected $defaultobject_type='lattice_cms';

 /*
  Function: __constructor
  Loads sub_modules to build from config 
 */
 public function __construct($request, $response)
{
  parent::__construct($request, $response);
     
  $this->modules = Kohana::config('cms.sub_modules');

  $this->load_resources('lattice_cms');

  lattice::config('objects', 'object_types');

 }

 public function get_root_node()
{
  throw new Kohana_Exception('Child class must implement get_root_node()');
 }

 public function action_index()
{
  $this->view = new View('lattice_cms');
  if (Auth::instance()->logged_in('superuser'))
{
   $this->view->userlevel = 'superuser';
  } else {
   $this->view->userlevel = 'basic';
  } 
      
      
  //get the root noode

  $root_object = $this->get_root_object();
  $this->view->root_object_id = $root_object->id;
      
  
  //basically this is an issue with wanting to have multiple things going on
  //with the same controller as a parent at runtime
  $this->view->navigation = Request::factory(Kohana::config($this->controller_name.'.navigation_request'))->execute()->body();

  //get all the languages
  $languages = ORM::Factory('language')->find_all();
  $this->view->languages = $languages;
  
  $this->response->body($this->view->render());
 }

 /*
  * Function: set_page_id($object_id)
  * Sets the object id of the object currently being edited
  * Parameters:
  * object_id  - the object id
  * Returns: nothing 
  */
 private function set_page_id($object_id)
{
  if (self::$object_id == NULL)
{
   self::$object_id = $object_id;
  }
 }

 /*
  * Function: get_page_id() 
  * Returns the object id of the object currently being edited
  * Parameters: none
  * Returns: object id
  */
 public static function get_page_id()
{
   return self::$object_id;
 }

 /*
 Function: get_page(id)
 Builds the editing object for the object currenlty being edited
 Parameters: 
 id - the object id to be retrieved
 Returns: array('html'=>html, 'js'=>js, 'css'=>css)
  */
 public function action_get_page($id, $language_code = NULL)
{



   if (!$language_code)
{
     $object = Graph::object($id);
   } else {
     $object = Graph::object($id)->translate($language_code);
   }

   self::$object_id = $id;


   /*
    * If the request is actually for a module, instead of a object, build
    * the subrequest and set the response body to the request.
    * This should probably be re-engineered to be handled by the navi
    * module only, and cms_modules.xml should also be a navi thing
    * since only the navi needs to know about the modules being loaded as long
    * as the reciever (CMS in this case) has an appropriate container.
    */
   if (!$object->loaded())
{
     $controller = $id;
     if (Kohana::find_file('classes/controller', $controller))
{
       $route = Request::Factory($controller);
       $this->response->body($route->execute()->body());
       return;
     }
   }


   if ($object->id == 0)
{
     throw new Kohana_Exception('Invalid Page Id '.$id);
   }

   //new generation of object
   //1 grap cms_nodetitle
   $this->nodetitle = new View('lattice_cms_nodetitle');
   $this->nodetitle->title = $object->title; //this should change to object table
   $this->nodetitle->slug = $object->slug;
   $this->nodetitle->id = $object->id;
   $this->nodetitle->allow_delete = $object->objecttype->allow_delete;
   $this->nodetitle->allow_title_edit = ($object->objecttype->allow_title_edit == "TRUE" ? true : FALSE);


   $settings = Kohana::config('cms.defaultsettings');
   if (is_array($settings))
{
     foreach ($settings as $key=>$value)
{
       $this->nodetitle->$key = $value;
     }
   }
   //and get settings for specific object_type
   $settings = Kohana::config('cms.'.$object->objecttype->objecttypename.'.defaultsettings');
   if (is_array($settings))
{
     foreach ($settings as $key=>$value)
{
       $this->nodetitle->$key = $value;
     }
   }
   if ($language_code)
{
     $this->nodetitle->translation_modifier = '_'.$language_code;
   } else {
     $this->nodetitle->translation_modifier = '';
   }

   $nodetitlehtml = $this->nodetitle->render();
   $move_node_html = latticecms::move_node_html($object);

   $custom_view = 'lattice/object_types/'.$object->objecttype->objecttypename; //check for custom view for this object_type

   $html_chunks = latticecms::buildUIHtml_chunks_for_object($object, $language_code);
   if (Kohana::find_file('views', $custom_view))
{
     $html = $nodetitlehtml;
     $html .= $move_node_html;
     $view = new View($custom_view);
     $this->load_resources_for_key($custom_view);
     foreach ($html_chunks as $key => $value)
{
       $view->$key = $value;
     }
     $view->object = $object;
     $view->object_id = $object->id;
     $html .= $view->render();
   } else {
     $html = $nodetitlehtml . implode($html_chunks); 
     $nodetitlehtml . $move_node_html . implode($html_chunks);
   }
   // $html .= $users_list_html;
   $this->response->data($object->get_page_content()); 
   $this->response->body($html);

 }


 public function action_get_translated_page($object_id, $language_code)
{
   return $this->action_get_page($object_id, $language_code);
 }

 public function action_addchild($id, $objecttype_id)
{
   $data = $_POST;

   //add the file keys in so that we can look them up in the FILES array laster
   //consider just combining POST and FILES here
   $file_keys = array_keys($_FILES);
   foreach ($file_keys as $fk)
{
     $data[$fk] = NULL; 
   }
   Kohana::$log->add(Log::INFO, var_export($data, TRUE));
   Kohana::$log->add(Log::INFO, var_export($_FILES, TRUE));
   $new_id = Graph::object($id)->add_object($objecttype_id, $data);
   $this->response->data($new_id);
 }

 /*
 Function: action_add_object($id)
 Public interface for adding an object to the cms data
 Parameters:
 id - the id of the parent category
 objecttype_id - the type of object to add
 title - optional title for initialization
 $_POST - possible array of keys and values to initialize with
 Returns: nav controller node object
  */
 public function action_add_object($parent_id, $object_type_id)
{      
   $new_id = $this->cms_add_object($parent_id, $object_type_id, $_POST);
   $this->response->data( $this->cms_get_node_info($new_id) ); 
   $this->response->body( $this->cms_get_node_html($new_id));

 }

 public function assign_object_id()
{

   }

   
  
}

?>
