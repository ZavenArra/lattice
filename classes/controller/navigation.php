<?php
/**
 * Class: Navigation_Controller 
 *
 *
 */

class Controller_Navigation extends Controller_Lattice{

  private $default_add_category_text = '';
  private $default_add_leaf_text = '';

  public function __construct($request, $response)
  {
    parent::__construct($request, $response);
  }


  public function action_index($deeplink=NULL)
  {

    // $this->view = new View(strtolower($this->controllername));
    // //this should check and extend
    $this->view = new View('navigation');
    $this->response->body($this->view->render());

  }

  /*
   *
   * Override this function to use nav on other data sources
   *
   */
  public function get_tier($parent_id, $deeplink_path=array(), &$follow=FALSE)
  {
    $parent = Graph::object($parent_id);
    if ( ! $parent->loaded())
    {
      throw new Kohana_Exception('Invalid object id sent to get_tier');
    }

    $items = Graph::object($parent->id)
      ->lattice_children_query()
      ->active_filter();
    //  ->order_by('objectrelationships.sortorder', 'ASC');
    $items = $items->find_all();

    if ($items)
    {
      $send_item_containers = array(); // these will go first
      $send_item_objects = array();
      foreach ($items as $child)
      {

        // Check for Access to this object
        $roles = $child->roles->find_all();
        foreach ($roles as $role)
        {
          if ( ! latticeutil::check_access($role->name))
          {
            continue (2);
          } 
        }

        // Containers should be skipped
        if (strtolower($child->objecttype->nodeType) == 'container')
        {
          // we might be skipping this node
          $display = $child->objecttype->display;

          if ($display == 'inline')
          {
            continue;
          }
        }
        $send_item = Navigation::get_node_info($child);

        // implementation of deeplinking
        $send_item['follow'] = FALSE;
        if (in_array($child->id, $deeplink_path))
        {
          $send_item['follow'] = TRUE;
          $follow = TRUE;

          // and deeplinking for categories
          $follow_tier = FALSE;
          $child_tier = $this->get_tier($child->id, $deeplink_path, $follow_tier);
          if ($follow_tier == TRUE)
          {
            $send_item['follow'] = TRUE;
            $follow = 'TRUE';
          }
          $send_item['tier'] = $child_tier;
        }

        if (strtolower($child->objecttype->nodeType)=='container')
        {
          $send_item_containers[] = $send_item;
        } else {
          $send_item_objects[] = $send_item;
        }
      }
      // this puts the folders first
      $send_item_objects = array_merge($send_item_containers, $send_item_objects);


      // add in any modules
      if ($parent->id == Graph::get_root_node(Kohana::config('cms.graph_root_node'))->id )
      {
        $cms_modules = lattice::config('cms_modules', '//module');
        foreach ($cms_modules as $m)
        {
          $controller = $m->get_attribute('controller');
          $roles = Kohana::config(strtolower($controller).'.authrole', FALSE, FALSE); 
          $access_granted = latticeutil::check_access($roles);
          if ( ! $access_granted)
          {
            continue;
          }

          $entry = array();
          $entry['id'] = $m->get_attribute('controller');
          $entry['slug'] = $m->get_attribute('controller');
          $entry['nodeType'] = 'module';
          $entry['contentType'] = 'module';
          $entry['title'] = $m->get_attribute('label');
          $entry['page_length'] = Kohana::config('cms.associator_page_length');;
          $send_item_objects[] = $entry;
        }
      }
      $html = $this->render_tier_view($parent, $send_item_objects);
      $tier = array(
        'nodes' => $send_item_objects,
        'html' => $html
      );
      return $tier;
    }

    return NULL;

  }

  public function action_get_tier($parent_id, $deeplink=NULL)
  {

    // plan all parents for following deeplink
    $deeplink_path = array();

    if ($deeplink)
    {
      $object_id = $deeplink;
      while($object_id)
      {
        $object = Graph::object($object_id);
        $deeplink_path[] = $object->id;
        $parent = $object->get_lattice_parent();
        if ($parent)
        {
          $object_id = $parent->id;
        } else {
          $object_id = NULL;
        } 
      }
      $deeplink_path = array_reverse($deeplink_path);

    }

    // this database call happens twice, should be a class variable?
    $parent = Graph::object($parent_id);


    $tier = $this->get_tier($parent_id, $deeplink_path);


    $this->response->data(array('tier' => $tier));

  }

  private function render_tier_view($parent, $nodes)
  {

    $tier_view = new View('navigation_tier');
    $nodes_html = array();
    foreach ($nodes as $node)
    {
      $node_view = new View('navigation_node');
      $node_view->content = $node; 
      $nodes_html[] = $node_view->render();
    }
    $tier_view->nodes = $nodes_html;

    $tier_methods_drawer = new View('tier_methods_drawer');
    $addable_objects = $parent->objecttype->addable_objects;

    if (latticeutil::check_access('superuser'))
    {
      foreach ($this->get_object_types() as $object_type)
      {
        $addable_object = array();
        $addable_object['object_type_id'] = $object_type['object_type_name'];
        $addable_object['object_type_add_text'] = "Add a ".$object_type['object_type_name'];
        $addable_object['nodeType'] = $object_type['node_type'];
        $addable_object['contentType'] = $object_type['content_type'];
        $addable_objects[] = $addable_object;
      }
    }
    $tier_methods_drawer->addable_objects = $addable_objects;

    $tier_view->tier_methods_drawer = $tier_methods_drawer->render();
    return $tier_view->render();

  }

  public function get_object_types()
  {
    $object_types = array();
    foreach (lattice::config('objects', '//objectType') as $object_type)
    {
      $entry = array();
      $entry['object_type_name'] = $object_type->get_attribute('name'); 
      $entry['label'] = $object_type->get_attribute('name').' label'; 
      $entry['nodeType'] = $object_type->get_attribute('node_type'); 
      $entry['contentType'] = $object_type->get_attribute('content_type'); 
      $object_types[] = $entry;
    }
    return $object_types;
  }

}

?>
