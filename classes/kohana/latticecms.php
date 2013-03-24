<?php

/* Class: CMS helper
 * Contains utility function for CMS
 */
/* @package Lattice */

class Kohana_Latticecms {

  private static $unique = 0;

  public static function unique_element_id()
  {
    return self::$unique++;
  }

  /*
   * Function: buildUIHtml_chunks
   * This function builds the html for the UI elements specified in an object type's paramters
   * Parameters:
   * $parameters - the parameters array from an object type configuration
   * Returns: Associative array of html, one entry for each ui element
   */

  public static function buildUIHtml_chunks($elements, $object = NULL)
  {
    $view = new View();
    $html_chunks = array();
    if (is_array($elements))
    {
      foreach ($elements as $element)
      {

        // check if this element type is in fact a object_type
        $x_path =  sprintf('//objectType[@name="%s"]', $element['type']);
        $t_config = lattice::config('objects', $x_path)->item(0);

        if ($t_config)
        {

          $field = $element['name'];
          $cluster_object = $object->$field;
          if ( ! $cluster_object)
          {
            throw new Kohana_Exception('Cluster Object did not load for '.$object->id.': '.$field);
          }

          $cluster_html_chunks = latticecms::buildUIHtml_chunks_for_object($cluster_object);


          $customview = 'lattice/object_types/' . $cluster_object->objecttype->objecttypename; // check for custom view for this object_type
          $usecustomview = FALSE;
          if (Kohana::find_file('views', $customview))
          {
            $usecustomview = TRUE;
          }
          if ( ! $usecustomview)
          {
            $html = implode($cluster_html_chunks);
            $view = new View('ui/clusters_wrapper');
            $view->label = $element['label'];
            $view->html = $html;
            $view->object_type_name = $cluster_object->objecttype->objecttypename;
            $view->object_id = $cluster_object->id;
            $html = $view->render();
          } else {
            $view = new View($customview);
            // $view->load_resources();
            $view->label = $element['label'];
            $view->object_type_name = $cluster_object->objecttype->objecttypename;
            $view->object_id = $cluster_object->id;
            foreach ($cluster_html_chunks as $key => $value)
            {
              $view->$key = $value;
            }
            $html = $view->render();
          }
          $html_chunks[$element['type'] . '_' . $element['name']] = $html;
          continue;
        }

        /*
         * Set up UI arguments to support uniquely generated field names when
         * multiple items being displayed have the same field names
         */
        $ui_arguments = $element;
        if (isset($element['field_id']))
        {
          $ui_arguments['name'] = $element['field_id'];
        }

        switch ($element['type'])
        {


        case 'element': // this should not be called 'element' as element has a different meaning
          if (isset($element['arguments']))
          {
            $html = lattice::build_module($element, $element['elementname'], $element['arguments']);
          } else {
            $html = lattice::build_module($element, $element['elementname']);
          }
          $html_chunks[$element['modulename']] = $html;
          break;
        case 'list':
          if (isset($element['display']) AND $element['display'] != 'inline')
          {
            break; // element is being displayed via navi, skip
          }
          $element['elementname'] = $element['name'];
          $element['controllertype'] = 'list';

          /* HERE! */

          $requestURI = 'list/get_list/' . $object->id . '/' . $element['name'];
          $html_chunks[$element['name']] = Request::factory($requestURI)->execute()->body();
          break;

        case 'associator':
          $associator = new Associator($object->id, $element['lattice'],$element['filters']);
          $associator->set_label($element['label']);
          $associator->set_pool_label($element['pool_label']);
          $associator->set_page_length(Kohana::config('cms.associator_page_length'));
          $key = $element['type'] . '_' . $ui_arguments['name'];
          $html_chunks[$key] = $associator->render($element['associator_type']);
          break;

        case 'tags':
          $tags = $object->get_tag_strings();
          $element_html = latticeui::tags($tags);
          $key = $element['type'] . '_tags';
          $html_chunks[$key] = $element_html;

          break;

        case 'password':
          $key = $element['type'] . '_' . $ui_arguments['name'];
          $html = self::buildUIElement($element, $ui_arguments, NULL);
          $html_chunks[$key] = $html;
          break;

        default:
          // deal with html object_type elements
          $key = $element['type'] . '_' . $ui_arguments['name'];
          $html = self::buildUIElement($element, $ui_arguments, $object->{$element['name']});
          $html_chunks[$key] = $html;
          break;
        }
      }
    }


    // print_r($html_chunks);
    return $html_chunks;
  }

  private static function buildUIElement($element, $ui_arguments, $value)
  {

    $html = NULL;
    if ( ! isset($element['name']))
    {
      $element['name'] = LatticeCMS::unique_element_id();
      $html = latticeui::buildUIElement($element, NULL);
    } elseif ( ! $html = latticeui::buildUIElement($ui_arguments, $value))
    {
      throw new Kohana_Exception('bad config in cms: bad ui element');
    }
    return $html;
  }

  public static function get_element_config($object, $element_name)
  {
    latticecms::get_element_dom_node($object, $element_name);
    return self::convert_xml_element_to_array($object, $element->item(0));
  }

  public static function get_element_dom_node($object, $element_name)
  {
    $x_path = sprintf('//objectType[@name="%s"]/elements/*[@name="%s"]',
      $object->objecttype->objecttypename,
      $element_name
    );
    $element = lattice::config('objects', $x_path);
    if ( ! $element OR !$element->length )
    {
      throw new Kohana_Exception('x_path returned no results: '. $x_path);
    }
    return $element->item(0);

  }

  public static function buildUIHtml_chunks_for_object($object, $translated_language_code = NULL)
  {
    $elements = lattice::config('objects', sprintf('//objectType[@name="%s"]/elements/*', $object->objecttype->objecttypename));
    //  should be Model_object->get_elements();
    //  this way a different driver could be created for non-xml config if desired
    $elements_config = array();
    foreach ($elements as $element)
    {

      $entry = self::convert_xml_element_to_array($object, $element);
      $elements_config[$entry['name']] = $entry;
    }
    return latticecms::buildUIHtml_chunks($elements_config, $object);
  }

  public static function convert_xml_element_to_array($object, $element)
  {
    $entry = array();
    // $entry should become an object, that contains configuration logic for each  view
    // or better yet, each mopui view should have it's own view object
    // which translates the configuration into the view display

    $entry['type'] = $element->tagName;
    for ($i = 0; $i < $element->attributes->length; $i++)
    {
      $entry[$element->attributes->item($i)->name] = $element->attributes->item($i)->value;
    }
    // load defaults
    $entry['tag'] = $element->getAttribute('tag');
    $entry['is_multiline'] = ( $element->getAttribute('is_multiline') == 'TRUE' )? true : FALSE;
    // any special xml reading that is necessary
    switch ($entry['type'])
    {
    case 'file':
    case 'image':
      $ext = array();
      $children = lattice::config('objects', 'ext', $element);
      foreach ($children as $child)
      {
        if ($child->tagName == 'ext')
        {
          $ext[] = $child->nodeValue;
        }
      }
      $entry['extensions'] = implode(',', $ext);
      break;
    case 'radio_group':
      $children = lattice::config('objects', 'radio', $element);
      $radios = array();
      foreach ($children as $child)
      {
        $label = $child->getAttribute('label');
        $value = $child->getAttribute('value');
        $radios[$label] = $value;
      }
      $entry['radios'] = $radios;
      break;

      //  Begin pulldown change
    case 'pulldown':
      $children = lattice::config('objects', 'option', $element); // $element['type']);
      $options  = array();
      foreach ($children as $child)
      {
        $label = $child->getAttribute('label');
        $value = $child->getAttribute('value');
        $options[$value] = $label;
      }
      $entry['options'] = $options;  
      break;


    case 'associator':
      // need to load filters here

      $entry['filters'] = Associator::get_filters_from_dom_node($element);
      $entry['pool_label'] = $element->getAttribute('pool_label');
      $entry['associator_type'] = $element->getAttribute('associator_type');
      $entry['page_length'] = Kohana::config('cms.associator_page_length');;
      break;
    case 'tags':
      $entry['name'] = 'tags'; // this is a cludge
      break;

    default:
      break;
    }
    return $entry;

  }

  public static function regenerate_images()
  {
    // find all images
    foreach (lattice::config('objects', '//objectType') as $object_type)
    {
      foreach (lattice::config('objects', 'elements/*', $object_type) as $element)
      {
        if ($element->tagName == 'image')
        {
          $objects = ORM::Factory('objecttype', $object_type->getAttribute('name'))->get_active_members();
          $fieldname = $element->getAttribute('name');
          foreach ($objects as $object)
          {
            if (is_object($object->$fieldname) AND $object->$fieldname->filename AND file_exists(Graph::mediapath() . $object->$fieldname->filename))
            {
              $uiresizes = Kohana::config('lattice_cms.uiresizes');
              $object->process_image($object->$fieldname->filename, $fieldname, $uiresizes);
            }
          }
        }
      }
    }
  }

  public static function generate_new_images($object_ids)
  {
    foreach ($object_ids as $id)
    {
      $object = Graph::object($id);
      foreach (lattice::config('objects', sprintf('//objectType[@name="%s"]/elements/*', $object->objecttype->objecttypename)) as $element)
      {
        if ($element->tagName == 'image')
        {
          $fieldname = $element->getAttribute('name');
          if (is_object($object->$fieldname) AND $object->$fieldname->filename AND file_exists(Graph::mediapath() . $object->$fieldname->filename))
          {
            $uiresizes = Kohana::config('lattice_cms.uiresizes');
            $object->process_image($object->$fieldname->filename, $fieldname, $uiresizes);
          }
        }
      }	
    }
  }



  public static function save_http_post_file($objectid, $field, $post_file_vars)
  {
    Kohana::$log->add(Log::ERROR, 'save uploaded');
    $object = Graph::object($objectid);
    // check the file extension
    $filename = $post_file_vars['name'];
    $ext = substr(strrchr($filename, '.'), 1);
    switch ($ext)
    {
    case 'jpeg':
    case 'jpg':
    case 'gif':
    case 'png':
    case 'JPEG':
    case 'JPG':
    case 'GIF':
    case 'PNG':
    case 'tif':
    case 'tiff':
    case 'TIF':
    case 'TIFF':
      Kohana::$log->add(Log::ERROR, 'save uploaded');
      $uiresizes = Kohana::config('lattice_cms.uiresizes');
      return $object->save_uploaded_image($field, $post_file_vars['name'], $post_file_vars['type'], $post_file_vars['tmp_name'], $uiresizes);
      break;

    default:
      return $object->save_uploaded_file($field, $post_file_vars['name'], $post_file_vars['type'], $post_file_vars['tmp_name']);
    }
  }

  public static function move_node_html($object)
  {
    $object_type_name = $object->objecttypename;
    $x_path = sprintf('//objectType[addableObject[@objectTypeName="%s"]]', $object_type_name);
    $object_types_result = lattice::config('objects', $x_path);

    $object_types = array();
    foreach ($object_types_result as $object_type)
    {
      $object_type = $object_type->getAttribute('name');
      $object_types[$object_type] = $object_type; 
    }

    $parent_candidates = array();
    foreach ($object_types as $object_type)
    {
      $objects = Graph::object()->object_type_filter($object_type)->active_filter()->find_all();
      foreach ($objects as $object)
      {
        $title = $object->title;
        if ( ! $title)
        {
          $title = $object->slug;
        }
        $parent_candidates[$object->id] = $title;
      }
    }
    natsort($parent_candidates);

    $view = new View('move_controls');
    $view->potential_parents = $parent_candidates;
    $html = $view->render();
    return $html;
  }

  // a list of users of $type
  public static function users_list_html($object)
  {
    // get all of the users of $type
    $user = ORM::Factory('user');
    $users = $user->find_all(); 
    $users_list = array();
    $checked = array();
    $checked_users = $object->get_user_objects();
    // now grab the users from this particular object and match those to be checked
    foreach ($checked_users as $c_user)
    {
      $checked[] = $c_user->user_id;
    }
    foreach ($users as $user)
    {
      $check = (in_array($user->id,$checked)) ? TRUE : FALSE;
      $users_list[] = array("id"=>$user->id,"username"=>$user->username,"checked"=>$check);
    }
    // make a basic array of username, user display name, id
    $view = new View('users_list');
    $view->users_list = $users_list;
    $html = $view->render();
    return $html;
  }

}


