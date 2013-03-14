<?php

/*
 * This class should have it's API changed to respect calling via the Container object Id
 * The container object ID is actually the ID of the list object itself, currently we're addressing
 * lists by family name and parent id, which is actually redundant.
 */


/*
  Class: List_module_Controller

 */

class Controller_List extends Lattice_CMSInterface {
  /*
   *  Variable: object_id
   *  static int the global object id when operating within the CMS submodules get the object id
   *  we could just reference the primary_id attribute of Display as well...
   */

  private static $object_id = NULL;


   /*
     Variable: model
     Main model for items content managed by this class
    */
  protected $model = 'object';

  /*
   * Variable: container_object
   * The parent object of the lists children
   */
  protected $_container_object;
  protected $_family;


  protected $_list_object;




   /*
     Function:  construct();
     Parameters:
    */

  public function __construct($request, $response)
  {
    parent::__construct($request, $response);

  }


  protected function set_list_object($list_object_id_or_parent_id, $family=NULL)
  {
    if ($family != NULL)
    {
      $parent_id = $list_object_id_or_parent_id;

      $list_container_object = Graph::object($parent_id)->$family;


      if ( ! $list_container_object->loaded())
      {
        throw new Kohana_Exception('Did not find list container List object is missing container: :id', array(':id' => $lt->id));
      }

      $this->_list_object = $list_container_object;

    } else {

      $this->_list_object = ORM::Factory('listcontainer', $list_object_id_or_parent_id);
    }

    if ( ! $this->_list_object->loaded())
    {
      throw new Kohana_Exception('Failed to load list object');
    }

  }


  /*
   * Function: action_get_list
   * Supports either calling with list object id directly, or with parent_id and family 
   * for looking in database and config
   */

  public function action_get_list($list_object_id_or_parent_id, $family = NULL)
  {

    $this->set_list_object($list_object_id_or_parent_id, $family);

    // throw new Kohana_Exception('what');

    $view = NULL;
    $custom_list_view = 'lattice/object_types/'.$this->_list_object->objecttype->objecttypename;
    if (Kohana::find_file('views', $custom_list_view))
    {
      $view = new View($custom_list_view);
    } else {
      $view = new View('list');
    }

    $list_members = $this->_list_object->get_lattice_children();

    $html = '';
    foreach ($list_members as $object)
    {

      $html_chunks = latticecms::buildUIHtml_chunks_for_object($object);

      $custom_item_view = 'lattice/object_types/' . $object->objecttype->objecttypename;
      $item_view = NULL;
      if (Kohana::find_file('views', $custom_item_view))
      {
        $item_view = new View($custom_item_view);
        $this->load_resources_for_key($custom_item_view);
        foreach ($html_chunks as $key=>$value)
        {
          $item_view->$key = $value;
        }
        $item_view->object = $object;

      } else {
        $item_view = new View('list_item');
      }


      $item_view->ui_elements = $html_chunks;

      $data = array();
      $data['id'] = $object->id;
      $data['object_id'] = $this->_list_object->id;
      $data['instance'] = $this->_list_object->objecttype->templatname;
      $item_view->data = $data;

      $html.=$item_view->render();
    }


    // actually we need to do an absolute path for local config
    $list_config = $this->_list_object->get_config();
    $view->name = $list_config->get_attribute('name');
    $view->label = $list_config->get_attribute('label');
    $view->class = $list_config->get_attribute('css_classes');
    $view->class .= ' allow_child_sort-' . $list_config->get_attribute('allow_child_sort');
    $view->class .= ' sort_direction-' . $this->_list_object->get_sort_direction();
    $view->items = $html;
    $view->instance = $this->_list_object->objecttype->templatname;
    $view->addable_objects = $this->_list_object->objecttype->addable_objects;
    $view->list_object_id = $this->_list_object->id;


    $this->response->body($view->render());
  }


   /*
     Function: add_item()
     Adds a list item

     Returns:
     the rendered object_type of the new item
    */

  public function action_add_object($list_object_id, $object_type_id=NULL)
  {


    $this->set_list_object($list_object_id);  // This function should be removed
    // and all functionality simply moved to the model.


    $list_object = ORM::Factory('listcontainer', $list_object_id);


    // addable item should be specifid in the add_item call
    if ($object_type_id == NULL)
    {

      $addable_object_types = lattice::config('objects', sprintf('//list[@name="%s"]/addable_object', $list_object->objecttype->objecttypename));
      if ( ! $addable_object_types->length > 0)
      {
        throw new Kohana_Exception('No Addable Objects ' .' Count not locate configuration in objects.xml for ' . sprintf('//list[@name="%s"]/addableobject', $this->_family));
      }
      $object_type_id = $addable_object_types->item(0)->get_attribute('object_type_name');
    } 

    $new_id = $list_object->add_object($object_type_id);

    // $this->response->data( $this->cms_get_node_info($new_id) );	
    // $this->response->body( $this->cms_get_node_html($new_id));


    $object = Graph::object($new_id);

    /*Cludge to bypass echoing placeholders necessary to pass validation*/
    //  $item->username = NULL;
    //  $item->password = NULL;
    //  $item->email = NULL;
    /*End cludge*/

    $html_chunks = latticecms::buildUIHtml_chunks_for_object($object);

    $custom_item_view = 'lattice/object_types/' . $object->objecttype->objecttypename;
    $item_view = NULL;
    if (Kohana::find_file('views', $custom_item_view))
    {
      $item_view = new View($custom_item_view);
      foreach ($html_chunks as $key=>$value)
      {
        $item_view->$key = $value;
      }
      $item_view->object = $object;

    } else {
      $item_view = new View('list_item');
      $item_view->ui_elements = $html_chunks;

    }



    $data = array();
    $data['id'] = $new_id;
    $data['object_id'] = $list_object_id;
    ;
    $data['instance'] = $this->_list_object->objecttype->objecttypename;


    $item_view->data = $data;

    $html = $item_view->render();

    $this->response->body($html);
  }


}

?>
