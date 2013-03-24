<?php

Class Controller_CSV extends Controller {

  private $csv_output = '';
  private $level = 0;
  private $line_number = 0;

  public function __construct($request, $response)
  {
    parent::__construct($request, $response);
    if ( ! cms_util::check_role_access('superuser')  AND PHP_SAPI != 'cli' )
    {
      die('Only superuser can access builder tool');
    }
  }

  public function action_index()
  {
    $view = new View('csv/index');
    $this->response->body($view->render());
  }

  public function action_export($export_file_identifier='lattice_csv_export')
  {
    $this->csv_output = '';

    $root_object = Graph_Core::get_lattice_root();


    $this->level = 0;

    try {
      $this->csv_walk_tree($root_object);
    } catch (Exception $e)
    {
      echo  "Error at line {$this->line_number} \n";
      throw $e;
    }

    $filename = $export_file_identifier .'.csv';
    $filepath = 'application/export/'.$filename;
    $file = fopen($filepath, 'w');
    fwrite($file, $this->csv_output);
    //  exit;
    header("Pragma: public");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Cache-Control: private",FALSE);
    header("Content-Type: csv");
    header("Content-Disposition: attachment; filename=\"".$filename."\";");
    header("Content-Transfer-Encoding: binary");
    header("Content-Length: ".@filesize($filepath));
    set_time_limit(0);
    @readfile($filepath) or throw new Kohana_Exception("File not found."); 
    exit;
  }

  private function csv_walk_tree($parent, $example = FALSE)
  {
    $objects = $parent->get_lattice_children();

    if ($example OR ($this->level > 0 AND count($objects)))
    {
      $children_line = array_pad(array('Children'), -1 - $this->level, '');
      $this->csv_output .= cms_util::array_to_csv($children_line, ',');
      $this->csv_output .= "\n";
    }

    foreach ($objects as $object)
    {

      $csv_view = NULL;
      if ($object->objecttype->nodeType != 'container')
      {
        $csv_view = new View_CSV($this->level, $object);
      } else {
        $csv_view = new View_CSVContainer($this->level, $object);
      }
      $this->csv_output .= $csv_view->render();
      $this->level++;
      $this->csv_walk_tree($object, FALSE);  // false turning off example for now
      // big problem with walking descedent objects since they don't exist

      if ($example)
      {
        // And now append one example object of each addable object
        foreach ($object->objecttype->addable_objects as $addable_object_type)
        {
          $object = Graph_Core::object()->set_object_type($addable_object_type['object_type_id']);


          $csv_view = new View_Csv($this->level, $object);
          $this->csv_output .= $csv_view->render();


        }
      }
      $this->level--;
    }

  }

  public function action_import()
  {
    $view = new View('csv/uploadform');
    $this->response->body($view->render());
  }

  public function action_importCSVFile($csv_file_name=NULL)
  {
    // get the php default Resource Limits
    $max_execution_time = ini_get("max_execution_time");
    $memory_limit = ini_get("memory_limit");


    $max_execution_time = ini_get("max_execution_time");
    $memory_limit = ini_get("memory_limit");

    if ($csv_file_name == NULL)
    {
      $this->csv_file = fopen($_FILES['upload']['tmp_name'], 'r');
    } else {
      $this->csv_file = fopen($csv_file_name, 'r');
    }
    $this->column = 0;

    $this->walkCSVObjects(Graph_Core::get_lattice_root());

    fclose($this->csv_file);

    try {
      latticecms::regenerate_images();
    } catch(Exception $e)
    {
      print_r($e->get_message() . $e->get_trace());
    }

    echo 'Done';
  }

  protected function walkCSVObjects($parent)
  {
    $this->advance();
    while($this->line)
    {
      $object_type_name = $this->line[$this->column];
      if ( ! $object_type_name)
      {
        throw new Kohana_Exception("Expecting object_type at column :column, but none found :line",
          array(
            ':column'=>$this->column,
            ':line'=>$this->line_number,
          )); 
      }

      // check if this object type is valid for the current objects.xml
      $object_config = lattice::config('objects', sprintf('//objectType[@name="%s"]', $object_type_name));
      if ( ! $object_config->item(0))
      {
        throw new Kohana_Exception("No object type configured in objects.xml for ".$object_type_name); 
      }

      // we have an object_type
      $new_object_id = $parent->add_object($object_type_name);
      $new_object = Graph_Core::object($new_object_id);
      $this->walkCSVElements($new_object);

    }

    echo 'Done';
    flush();
    ob_flush();
  }

  protected function walkCSVElements($object)
  {
    echo "Walking\n";

    if ($object->objecttype->nodeType != 'container')
    { 
      // get the elements line
      $this->advance();
      // check here for Elements in $this->column +1;
      if ( ! (isset($this->line[$this->column+1])) OR $this->line[$this->column+1] != 'Elements')
      {
        throw new Kohana_Exception("Didn't find expected Elements line at line ".$this->line_number);
      }
    }


    // iterate through any elements
    $this->advance(); 
    $data = array();
    while(isset($this->line[$this->column]) 
      AND $this->line[$this->column]=='' 
      AND $this->line[$this->column+1]!='' 
      AND $this->line[$this->column+1]!='Children')
    {
      $field_name = $this->line[$this->column+1]; 
      // echo "Reading $field_name \n";
      if (isset($this->line[$this->column+2]))
      {
        $value = $this->line[$this->column+2];
      } else {
        $value = NULL;
      }
      $field = strtok($field_name, '_');
      $lang = strtok('_');
      if ( ! isset($data[$lang]))
      {
        $data[$lang] = array();
      }
      $data[$lang][$field] = $value;

      $this->advance();
    }




    // and actually add the data to the objects
    foreach ($data as $lang=>$lang_data)
    {
      $object_to_update = $object->get_translated_object(Graph_Core::language($lang));
      foreach ($lang_data as $field => $value)
      {

        if ($field=='tags')
        {
          if ($value)
          {
            $tags = explode(',',$value); 
            foreach ($tags as $tag)
            {
              $object_to_update->add_tag($tag);
            }
          }
          continue;
        }

        $object_to_update->$field = $value;

        if (in_array($field, array('title', 'slug', 'published', 'dateadded')))
        {
          continue;
        }

        // need to look up field and switch on field type 
        $field_info = lattice::config('objects', sprintf('//objectType[@name="%s"]/elements/*[@name="%s"]',$object->objecttype->objecttypename, $field));
        $field_info = $field_info->item(0);
        if ( ! $field_info)
        {
          throw new Kohana_Exception("Bad field in data/objects! \n" . sprintf('//objectType[@name="%s"]/elements/*[@name="%s"]', $object->objecttype->objecttypename, $field));
        }


        // special setup based on field type
        switch ($field_info->tag_name)
        {
        case 'file':
        case 'image':
          $path_parts = pathinfo($value);
          $savename = Model_Object::make_file_save_name($path_parts['basename']);
          // TODO: Spec and engineer this, import media path needs to be fully workshopped
          // $import_media_path = Kohana::config('cms.import_media_path');
          // $image_path = $_SERVER['DOCUMENT_ROOT']."/".trim($import_media_path,"/")."/".$value;
          $image_path = $value;
          if (file_exists($image_path))
          {
            copy($image_path, Graph_Core::mediapath($savename) . $savename);
            $file = ORM::Factory('file');
            $file->filename = $savename;
            $file->save();
            $object_to_update->$field = $file->id;
          } else {
            if ($value)
            {
              echo "file does not exist";
              // throw new Kohana_Exception( "File does not exist {$value} ");
            }
          }
          break;
        default:
          break;
        }


      }
      $object_to_update->save();
    }

    // Check here for Children in $this->column +1
    if ( ! isset($this->line[$this->column+1]) OR $this->line[$this->column+1] != 'Children')
    {
      echo "No children found, returning from Walk ";// .implode(',', $this->line)."\n";
      return;
    }

    // Iterate through any children
    $this->advance();
    while(isset($this->line[$this->column]) 
      AND $this->line[$this->column]=='' 
      AND $this->line[$this->column+1]!='')
    {
      // echo "foudn Child\n";
      // echo $this->column;
      $child_object_type_name = $this->line[$this->column+1]; 
      $child_object_id = $object->add_object($child_object_type_name);
      $child_object = Graph_Core::object($child_object_id);
      $this->column++;
      // echo $this->column;
      $this->walkCSVElements($child_object);
      $this->column--;
    }

    echo "Returning from Walk\n";
    // at this point this->line contains the next object to add at this depth level

  }

  protected function advance()
  {
    $this->line_number++;
    $this->line = fgetcsv($this->csv_file);
  }

}
