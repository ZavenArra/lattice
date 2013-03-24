<?php

/**
 * Class: CMS_Intergace_Controller
 * The main CMS class, handling add, delete, and retrieval of objects
 * @author Matthew Shultz
 * @package Lattice
 */
abstract class Lattice_Core_CMSInterface extends Controller_Layout {


  public function __construct($request, $response)
  {
    parent::__construct($request, $response);
  }


  /*
   * Function:  save_file($object_id)
   * Function called on file upload
   * Parameters:
   * objectid  - the object id of the object currently being edited
   * $_POST['field'] - the content table field for the file
   * $_FILES[{fieldname}] - the file being uploaded
   * Returns:  array(
     'id'=>$file->id,
     'src'=>$this->basemediapath.$savename,
     'filename'=>$savename,
     'ext'=>$ext,
     'result'=>'success',
   );
   */

  public function action_save_file($object_id)
  {

    try {

      $this->save_file($object_id);

    } catch (Exception $e)
    {

      // return the model errors gracecully;

      $this->handle_data_exception($e);

    }
  }

  public function save_file($object_id)
  {

    $field = strtok($_POST['field'], '_');

    $file = latticecms::save_http_post_file($object_id, $field, $_FILES['Filedata']);
    $result = array(
      'id' => $file->id,
      'src' => $file->original->fullpath,
      'filename' => $file->filename,
      'ext' => $file->ext,
      'result' => 'success',
    );

    // if it's an image
    $thumb_src = NULL;
    if ($file->uithumb->filename)
    {
      if (file_exists(Graph_Core::mediapath() . $file->uithumb->filename))
      {
        $resultpath = Graph_Core::mediapath() . $file->uithumb->filename;
        $thumb_src = $resultpath; // Kohana::config('cms.basemediapath') . $file->uithumb->fullpath;
      }
    }
    if ($thumb_src)
    {
      $size = getimagesize($resultpath);
      $result['width'] = $size[0];
      $result['height'] = $size[1];
      $result['thumb_src'] = $thumb_src;
    }

    $this->response->data($result);
  }

  public function action_clear_field($object_id, $field)
  {

    $object = Graph_Core::object($object_id);
    if (Graph_Core::is_file_model($object->$field) AND $object->$field->loaded())
    {
      $file = $object->$field;
      $file->delete();
    }
    $object->$field = NULL;
    $return = array('cleared' => 'TRUE');
    $this->response->data($return);
  }

  /*
   *
   * Function: action_save_field()
   * Saves data to a field via ajax.  Call this using /cms/ajax/save/{objectid}/
   * Parameters:
   * $id - the id of the object currently being edited
   * $_POST['field'] - the content table field being edited
   * $_POST['value'] - the value to save
   * Returns: array('value'=>{value})
   */

  public function action_save_field($id)
  {

    try {

      $this->save_field($id);
    } catch (Exception $e)
    {

      // return the model errors gracecully;

      $this->handle_data_exception($e);
    }
  }

  /*
   *
   * Function: _save_field()
   * Saves data to a field via ajax.  Call this using /cms/ajax/save/{objectid}/
   * Parameters:
   * $id - the id of the object currently being edited
   * $_POST['field'] - the content table field being edited
   * $_POST['value'] - the value to save
   * Returns: array('value'=>{value})
   */

  public function save_field($id)
  {

    // $field = strtok($_POST['field'], '_');
    $field = $_POST['field'];


    $object = Graph_Core::object($id);
    $object->$field = $_POST['value'];
    $object->save();

    $return_data = array();
    if (count($object->get_messages()))
    {
      $return_data['messages'] = $object->get_messages();
    }

    $object = Graph_Core::object($id);
    $value = $object->$field;

    $config = $object->get_element_config($field);

    $return_data['value'] = $value;

    if ($_POST['field'] == 'title')
    {
      $return_data['slug'] = $object->slug;
    }
    $this->response->data($return_data);
  }

  public function action_move($object_id, $new_parent_id, $lattice='lattice', $old_parent_id=NULL)
  {
    $object = Graph_Core::object($object_id);
    $object->move($new_parent_id, $lattice, $old_parent_id);
    $this->response->data(array('new_parent_id', $object->get_lattice_parent($lattice)->id));
  }


  /*
   * Function: handle_data_exception();
   */

  protected function handle_data_exception($e)
  {

    if (get_class($e) != 'ORM_Validation_Exception')
    {
      throw $e;
    }
    $model_errors = $e->errors('validation');

    if (isset($model_errors['_external']))
    {
      $model_errors = array_values($model_errors['_external']);
    }

    $firstkey = array_keys($model_errors);
    $firstkey = $firstkey[0];

    $return = $this->response->data(array('value' => NULL, 'error' => 'TRUE', 'message' => $model_errors[$firstkey]));
  }

   /*
     Function: toggle_publish
     Toggles published / unpublished status via ajax. Call as cms/ajax/toggle_publish/{id}/
     Parameters:
     id - the id to toggle
     Returns: Published status (0 or 1)
    */

  public function action_toggle_publish($id)
  {
    $object = Graph_Core::object($id);
    if ($object->published == 0)
    {
      $object->published = 1;
    } else {
      $object->published = 0;
    }
    $object->save();

    $this->response->data(array('published' => $object->published));
  }

   /*
     Function: save_sort_order
     Saves sort order of some ids
     Parameters:
     $_POST['sort_order'] - array of object ids in their new sort order
    */

  public function action_save_sort_order($parent_id, $lattice='lattice')
  {

    if ($_POST['sort_order'])
    {
      $order = explode(',', $_POST['sort_order']);
      $object = ORM::Factory('object', $parent_id);
      $object->set_sort_order($order, $lattice);
    }

    $this->response->data(array('saved' => TRUE));
  }

  public function action_add_tag($id)
  {
    $object = Graph_Core::object($id);
    $object->add_tag($_POST['tag']);
  }

  public function action_remove_tag($id)
  {
    $object = Graph_Core::object($id);
    $object->remove_tag($_POST['tag']);
  }

  public function action_get_tags($id)
  {

    $tags = Graph_Core::object($id)->get_tag_strings();
    $this->response->data(array('tags' => $tags));
  }

   /*
     Function: delete
     deletes a object/category and all categories and leaves underneath
     Returns: returns html for undelete pane
    */
  public function action_remove_object($id)
  {
    $object = Graph_Core::object($id);
    $object->deactivate($id);

    $view = new View('lattice_cms_undelete');
    $view->id = $id;
    $this->response->body($view->render());
    $this->response->data(array('deleted' => TRUE));
  }

   /*
     Function: undelete
     Undeletes a object/category and all categories and leaves underneath

     Returns: 1;
    */
  public function action_undelete($id)
  {
    $object = Graph_Core::object($id);
    $object->reactivate($id);
    $this->response->data(array('undeleted' => TRUE));
  }

  public function action_associate($parent_id, $object_id, $lattice)
  {
    $parent = Graph_Core::object($parent_id);
    $parent->add_lattice_relationship($objectid, $lattice);
    $meta_object_type = $parent->get_meta_object_type($lattice);
  }

  public function action_disassociate($parent_id, $object_id, $lattice)
  {
    Graph_Core::object($parent_id)->remove_lattice_relationship($objectid, $lattice);
  }

  public function action_toggle_user_association($object_id)
  {
    // get user and object from post
    $user_id = $_POST["field"];
    $toggle_state = $_POST["value"];
    // check user is valid or bail
    $user_check =   ORM::factory('user',$user_id);
    if ( ! $user_check->loaded())
    {
      $this->response->data(array('error'=>TRUE,'message'=>'User does not exist'));
    } else {
      // if the toggle 
      if ($toggle_state==0)
      {
        $o = ORM::factory('objects_user')
          ->where('object_id','=',$object_id)
          ->where('user_id','=',$user_id);
        $results = $o->find_all();
        foreach ($results as $result)
        {
          $result->delete();
        }
        $this->response->data( array('value'=>$_POST["value"]) );
      } else {
        // the association doesn't exist so create it  
        $o = ORM::factory('objects_user');
        $o->user_id = $user_id;
        $o->object_id = $object_id;
        $o->save();
        $this->response->data( array('value'=>$_POST["value"]) );
      }  
    }
  }

  public function action_associateuser($user_id, $object_id)
  {
    // check 
    $user_check =   ORM::factory('user',$user_id);
    $exists_check = ORM::factory('objects_user')
      ->where('object_id','=',$object_id)
      ->where('user_id','=',$user_id)->find();
    if ($user_check->loaded() AND ( ! $exists_check->loaded()))
    {
      $o = ORM::factory('objects_user');
      $o->user_id = $user_id;
      $o->object_id = $object_id;
      $o->save();
      echo json_encode(TRUE);
    } else {
      echo json_encode(FALSE);
    }
  }



  // abstract
  protected function cms_get_node($id)
  {

  }

  // abstract
  protected function cms_add_object($parent_id, $object_type_id, $data)
  {

  }


  public function action_get_children_paged($id,$page_num)
  {
    $object = Graph_Core::object($id);
    $object->set_page_num($page_num);
    //      $object->set_items_per_page(2);
    $ret = $object->lattice_children_filter_paged($id,"lattice");
  }
}

?>
