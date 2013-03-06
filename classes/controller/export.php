<?php

class Controller_Export extends Controller {

   public $output_dir;

   public function __construct() {
      if (!is_writable('application/views/xmldumps/')) {
//	die('application/views/xmldumps/ must be writable');
      }
   }
//all this logic should be moved to the export MODEL
   private function get_object_fields($object) {
      $nodes = array();
      $content = $object->get_content();
      foreach ($content as $key => $value) {
         if ($key == 'object_type_name') {
            continue;
         }
         if ($key == 'id') {
            //continue;
         }
         $node = $this->doc->create_element($key);
         if (is_array($value)) {
            
         } else if (is_object($value)) {
            switch (get_class($value)) {
               case 'Model_File':
                  //or copy to directory and just use filename
                  if ($value->filename) {
										$target_path = $this->output_dir . $value->filename;
										if(file_exists($target_path)){
											$node->append_child($this->doc->create_text_node($target_path));
										}
                  }
                  break;
               case 'Model_Page':
                  foreach ($this->get_object_fields($value) as $sub_field) {
                     $node->append_child($sub_field);
                  }
                  break;
            }
         } else {
            $node->append_child($this->doc->create_text_node($value));
         }
         $nodes[] = $node;
      }
      return $nodes;
   }

   private function get_object_fields_lattice_format($object) {
      $nodes = array();
      $content = $object->get_content();
      foreach ($content as $key => $value) {
         if ($key == 'object_type_name' OR $key == 'dateadded') {
            continue;
         }
         if ($key == "slug" AND $value == "") {
            continue;
         }
         if ($key == "title" AND $value == "") {
            //$value = microtime();
         }
         if ($key == "id") {
            continue;
         }
         if ($key != "tags" AND is_array($value)) {
            //skipping container objects.
            continue;
         }
    
         $node = $this->doc->create_element('field');
         $node_attr = $this->doc->create_attribute('name');
         $node_value = $this->doc->create_text_node($key);
         $node_attr->append_child($node_value);
         $node->append_child($node_attr);

         if (is_object($value)) {

           switch (get_class($value)) {
           case 'Model_File':
             //or copy to directory and just use filename
             if ($value->filename) {
               $target_path = $this->output_dir . $value->filename;
										 if(file_exists($target_path)){
											 $node->append_child($this->doc->create_text_node($target_path));
										 }
                  }
                  break;
               case 'Model_Object':
                  foreach ($this->get_object_fields_lattice_format($value) as $sub_element) {
										$node->append_child($sub_element);
                  }
                  break;
            }
         } else if($key == "tags") {

            $node->append_child($this->doc->create_text_node(implode(',',$value)));

         } else {

            $node->append_child($this->doc->create_text_node($value));
         }
         $nodes[] = $node;
			}
      $node = $this->doc->create_element('field');
      $node_attr = $this->doc->create_attribute('name');
      $node_value = $this->doc->create_text_node('published');
      $node_attr->append_child($node_value);
      $node->append_child($node_attr);
      $node->append_child($this->doc->create_text_node($object->published));
			$nodes[] = $node;
      return $nodes;
   }

   private function export_tier($objects) {

      $nodes = array();
      foreach ($objects as $object) {
         $item = $this->doc->create_element($object->objecttype->objecttypename);

         foreach ($this->get_object_fields($object) as $field) {
            $item->append_child($field);
         }

         //and get the children
         $child_objects = $object->get_lattice_children();

         foreach ($this->export_tier($child_objects) as $child_item) {
            $item->append_child($child_item);
         }
         $nodes[] = $item;
      }

      return $nodes;
   }

   private function export_tier_lattice_format($objects) {

      $nodes = array();
      foreach ($objects as $object) {
         $item = $this->doc->create_element('item');
         $object_type_attr = $this->doc->create_attribute('object_type_name');
         $object_type_value = $this->doc->create_text_node($object->objecttype->objecttypename);
         $object_type_attr->append_child($object_type_value);
         $item->append_child($object_type_attr);

         foreach ($this->get_object_fields_lattice_format($object) as $field) {
            $item->append_child($field);
         }

         //and get the children
         $child_objects = $object->get_lattice_children();
         foreach ($this->export_tier_lattice_format($child_objects) as $child_item) {
            $item->append_child($child_item);
         }
         $nodes[] = $item;
      }

      return $nodes;
   }

   //this should call action_export and then convert with xslt
   public function action_lattice($outputfilename='export') {

     $this->export('Lattice_format', $outputfilename);

   } 

   public function action_xml($outputfilename='export') {

     $this->export('XMLFormat', $outputfilename);

   } 

   public function export($format, $outputfilename){

		 $this->output_dir = 'application/export/' . $outputfilename . '/';

		 try {
		 mkdir($this->output_dir, 777);
		 } catch ( Exception $e){

		 }
		 chmod(getcwd() . '/' . $this->output_dir, 0777);
		 system('cp -Rp application/media/* ' . $this->output_dir);

     $XML = new DOMDocument();
     $implementation = new DOMImplementation();
     $dtd = $implementation->create_document_type('data',
       '-//WINTERROOT//DTD Data//EN',
        '../../../modules/lattice/lattice/data.dtd');
      $this->doc = $implementation->create_document('', '', $dtd);
   
      $this->doc->xml_version="1.0";
      $this->doc->encoding="UTF-8";
      $this->doc->format_output = true;
    
      $data = $this->doc->create_element('data');
      $nodes = $this->doc->create_element('nodes');

      $object = Graph::get_root_node('cms_root_node');
      $objects = $object->get_lattice_children();

      $export_function = NULL;
      switch($format){
      case 'Lattice_format':
        $export_function = 'export_tier_lattice_format';
        break;
      case 'XMLFormat':
        $export_function = 'export_tier';
         break;
      }

      foreach ($this->$export_function($objects) as $item) {
        $nodes->append_child($item);
      }
      $data->append_child($nodes);


      $relationships = $this->doc->create_element('relationships');

      $lattices = Graph::lattices();
      foreach($lattices as $lattice){
        if($lattice->name == 'lattice'){
          continue;
        }
        $l = $this->doc->create_element('lattice');
        $name_attr = $this->doc->create_attribute('name');
        $name_value = $this->doc->create_text_node($lattice->name);
        $name_attr->append_child($name_value);
        $l->append_child($name_attr);

        foreach($lattice->get_relationships() as $relationship){
          $r = $this->doc->create_element('relationship');
          $parent_slug = $this->doc->create_text_node(Graph::object($relationship->object_id)->slug);
          $parent = $this->doc->create_attribute('parent');
          $parent->append_child($parent_slug);
          $child_slug = $this->doc->create_text_node(Graph::object($relationship->connectedobject_id)->slug);
          $child = $this->doc->create_attribute('child');
          $child->append_child($child_slug);
          $r->append_child($parent);
          $r->append_child($child);
          $l->append_child($r);
        }
        $relationships->append_child($l);
      }

      $data->append_child($relationships);

      $this->doc->append_child($data);

      echo getcwd() . '/' . $this->output_dir;
      flush();
      ob_flush();
      $this->doc->save($this->output_dir . '/' . $outputfilename . '.xml');
      echo 'done';
   }

}
