<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of csv
 *
 * @author deepwinter1
 */
class View_Csv {

   private $_indent = 0;
   private $_object = 0;
   private $_object_type_name = '';
   private $skip_fields = array('slug', 'id', 'dateadded', 'objecttypename');

   public function __construct($indent, $object) {
      $this->_indent = $indent;
      $this->_object = $object;
      $this->_object_type_name = $object->objecttype->objecttypename;
   }

   public function render() {

      $object_type_line = array_pad(array($this->_object_type_name), -1 - $this->_indent, '');
      $csv = latticeutil::array_to_csv($object_type_line, ',');
      $csv .= "\n";
      $elements_line = array_pad(array('Elements'), -1 - ($this->_indent + 1), '');
      $csv .= latticeutil::array_to_csv($elements_line, ',');
      $csv .= "\n";

      $il8n_objects = array();
      $languages = Graph::languages();
      if (count($languages)) {
         foreach ($languages as $language) {
            if ($language->id != $this->_object->language_id) {
               $il8n_objects[$language->code] = $this->_object;
            } else {
               $il8n_objects[$language->code] = $this->_object->get_translated_object($language->id);
            }
         }
      } else {
         $il8n_objects['x'] = $this->_object;
      }

      $fields = $this->_object->get_fields();
      
      foreach ($this->_object->get_fields() as $column_name) {
                  
         if (in_array($column_name, $this->skip_fields)){
            continue;
         }         
         
         //cycle through all languages for each field

         //$languages = Graph::languages();
         //foreach ($languages as $translation_language) {
         
         if ($this->_object->loaded()){
            $data_item = $this->_object->$column_name;
         } else {
            $data_item = NULL;  //this allow for objects to be used as empty templates 
            //without being tied to database
            //potential refactor here, separating ideas of objecttype and object
            //a bit more
         }


         if (is_object($data_item)) {

            //        if (is_subclass_of($data_item, 'Model_File')) {
            // This is a special case, once Files are compound objects only
            // they will be subclass of Model_Object, and filename will be only
            // a text field, with file linked to object via  objectelementsrelationships.
            if (get_class($data_item) == 'Model_File') {

               $data_item_line = array_pad(array($column_name, $data_item->filename), - 2 - $this->_indent - 1, '');
               $csv .= latticeutil::array_to_csv($data_item_line, ',');
               $csv .= "\n";
               //and do the other languages
               foreach ($languages as $language) {
                  $data_item = $il8n_objects[$language->code]->$column_name;

                  if (count($language)>1){
                    $suffix =  '_' . $language->code;
                  } else {
                    $suffix = '';
                  }
                  $column_name_out = $column_name . $suffix;

                  $data_item_line = array_pad(array($column_name_out, $data_item->filename), - 2 - $this->_indent - 1, '');
                  $csv .= latticeutil::array_to_csv($data_item_line, ',');
                  $csv .= "\n";
               }
            } else {

               //skip if it's a container
               if ($data_item->objecttype->node_type == 'container') {
                  continue;
               }

               $csv_view = new View_Csv($this->_indent + 1, $data_item);
               $csv .= $csv_view->render();
               $csv .= "\n";
            }
         } else {

            foreach ($languages as $language) {
               $data_item = $il8n_objects[$language->code]->$column_name;
               if (is_array($data_item)) {
                  $data_item = implode($data_item, ',');
               }

               if (count($language)>1){
                 $suffix =  '_' . $language->code;
               } else {
                 $suffix = '';
               }
               $column_name_out = $column_name . $suffix;
               $data_item_line = array_pad(array($column_name_out, $data_item), - 2 - $this->_indent - 1, '');
               $csv .= latticeutil::array_to_csv($data_item_line, ',');
               $csv .= "\n";
            }
         }

      }
      return $csv;
      
   }
}

?>
