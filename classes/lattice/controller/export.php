<?php

class Lattice_Controller_Export extends Controller {

  public $output_dir;

  public function __construct()
  {
    if ( ! is_writable('application/views/xmldumps/'))
    {
      // 	die('application/views/xmldumps/ must be writable');
    }
  }
  // all this logic should be moved to the export MODEL
  private function get_object_fields($object)
  {
    $nodes = array();
    $content = $object->get_content();
    foreach ($content as $key => $value)
    {
      if ($key == 'objectTypeName')
      {
        continue;
      }
      if ($key == 'id')
      {
        // continue;
      }
      $node = $this->doc->createElement($key);
      if (is_array($value))
      {

      } elseif (is_object($value))
      {
        switch (get_class($value))
        {
        case 'Model_File':
          // or copy to directory and just use filename
          if ($value->filename)
          {
            $target_path = $this->output_dir . $value->filename;
            if (file_exists($target_path))
            {
              $node->appendChild($this->doc->createTextNode($target_path));
            }
          }
          break;
        case 'Model_Page':
          foreach ($this->get_object_fields($value) as $sub_field)
          {
            $node->appendChild($sub_field);
          }
          break;
        }
      } else {
        $node->appendChild($this->doc->createTextNode($value));
      }
      $nodes[] = $node;
    }
    return $nodes;
  }

  private function get_object_fields_lattice_format($object)
  {
    $nodes = array();
    $content = $object->get_content();
    foreach ($content as $key => $value)
    {
      if ($key == 'objectTypeName' OR $key == 'dateadded')
      {
        continue;
      }
      if ($key == "slug" AND $value == "")
      {
        continue;
      }
      if ($key == "title" AND $value == "")
      {
        // $value = microtime();
      }
      if ($key == "id")
      {
        continue;
      }
      if ($key != "tags" AND is_array($value))
      {
        // skipping container objects.
        continue;
      }

      $node = $this->doc->createElement('field');
      $node_attr = $this->doc->createAttribute('name');
      $node_value = $this->doc->createTextNode($key);
      $node_attr->appendChild($node_value);
      $node->appendChild($node_attr);

      if (is_object($value))
      {

        switch (get_class($value))
        {
        case 'Model_File':
          // or copy to directory and just use filename
          if ($value->filename)
          {
            $target_path = $this->output_dir . $value->filename;
            if (file_exists($target_path))
            {
              $node->appendChild($this->doc->createTextNode($target_path));
            }
          }
          break;
        case 'Model_Object':
          foreach ($this->get_object_fields_lattice_format($value) as $sub_element)
          {
            $node->appendChild($sub_element);
          }
          break;
        }
      } elseif ($key == "tags")
      {

        $node->appendChild($this->doc->createTextNode(implode(',',$value)));

      } else {

        $node->appendChild($this->doc->createTextNode($value));
      }
      $nodes[] = $node;
    }
    $node = $this->doc->createElement('field');
    $node_attr = $this->doc->createAttribute('name');
    $node_value = $this->doc->createTextNode('published');
    $node_attr->appendChild($node_value);
    $node->appendChild($node_attr);
    $node->appendChild($this->doc->createTextNode($object->published));
    $nodes[] = $node;
    return $nodes;
  }

  private function export_tier($objects)
  {

    $nodes = array();
    foreach ($objects as $object)
    {
      $item = $this->doc->createElement($object->objecttype->objecttypename);

      foreach ($this->get_object_fields($object) as $field)
      {
        $item->appendChild($field);
      }

      // and get the children
      $child_objects = $object->get_lattice_children();

      foreach ($this->export_tier($child_objects) as $child_item)
      {
        $item->appendChild($child_item);
      }
      $nodes[] = $item;
    }

    return $nodes;
  }

  private function export_tier_lattice_format($objects)
  {

    $nodes = array();
    foreach ($objects as $object)
    {
      $item = $this->doc->createElement('item');
      $object_type_attr = $this->doc->createAttribute('objectTypeName');
      $object_type_value = $this->doc->createTextNode($object->objecttype->objecttypename);
      $object_type_attr->appendChild($object_type_value);
      $item->appendChild($object_type_attr);

      foreach ($this->get_object_fields_lattice_format($object) as $field)
      {
        $item->appendChild($field);
      }

      // and get the children
      $child_objects = $object->get_lattice_children();
      foreach ($this->export_tier_lattice_format($child_objects) as $child_item)
      {
        $item->appendChild($child_item);
      }
      $nodes[] = $item;
    }

    return $nodes;
  }

  // this should call action_export and then convert with xslt
  public function action_lattice($outputfilename='export')
  {

    $this->export('Lattice_format', $outputfilename);

  } 

  public function action_xml($outputfilename='export')
  {

    $this->export('XMLFormat', $outputfilename);

  } 

  public function export($format, $outputfilename)
  {

    $this->output_dir = 'application/export/' . $outputfilename . '/';

    try {
      mkdir($this->output_dir, 777);
    } catch ( Exception $e)
    {

    }
    chmod(getcwd() . '/' . $this->output_dir, 0777);

    $XML = new DOMDocument();
    $implementation = new DOMImplementation();
      
    $dtd = $implementation->createDocumentType('data',
      '-//WINTERROOT//DTD Data//EN',
      '../../../modules/lattice/lattice/data.dtd');
    $this->doc = $implementation->createDocument('', '', $dtd);

    $this->doc->xml_version="1.0";
    $this->doc->encoding="UTF-8";
    $this->doc->format_output = TRUE;

    $data = $this->doc->createElement('data');
    $nodes = $this->doc->createElement('nodes');

    $object = Graph::get_root_node('cms_root_node');
    $objects = $object->get_lattice_children();

    $export_function = NULL;
    switch($format)
    {
    case 'Lattice_format':
      $export_function = 'export_tier_lattice_format';
      break;
    case 'XMLFormat':
      $export_function = 'export_tier';
      break;
    }

    foreach ($this->$export_function($objects) as $item)
    {
      $nodes->appendChild($item);
    }
    $data->appendChild($nodes);


    $relationships = $this->doc->createElement('relationships');

    $lattices = Graph::lattices();
    foreach ($lattices as $lattice)
    {
      if ($lattice->name == 'lattice')
      {
        continue;
      }
      $l = $this->doc->createElement('lattice');
      $name_attr = $this->doc->createAttribute('name');
      $name_value = $this->doc->createTextNode($lattice->name);
      $name_attr->appendChild($name_value);
      $l->appendChild($name_attr);

      foreach ($lattice->get_relationships() as $relationship)
      {
        $r = $this->doc->createElement('relationship');
        $parent_slug = $this->doc->createTextNode(Graph::object($relationship->object_id)->slug);
        $parent = $this->doc->createAttribute('parent');
        $parent->appendChild($parent_slug);
        $child_slug = $this->doc->createTextNode(Graph::object($relationship->connectedobject_id)->slug);
        $child = $this->doc->createAttribute('child');
        $child->appendChild($child_slug);
        $r->appendChild($parent);
        $r->appendChild($child);
        $l->appendChild($r);
      }
      $relationships->appendChild($l);
    }

    $data->appendChild($relationships);

    $this->doc->appendChild($data);

    // Copy media last to avoid mysql timeout
    system('cp -Rp application/media/* ' . $this->output_dir);

    flush();
    ob_flush();
    
    //format file
    $this->doc->formatOutput = true;
    
    $this->doc->save($this->output_dir . '/' . $outputfilename . '.xml');
    echo 'done';
  }

}
