<?php

/*
 *
 * Class: Model for Objectmap
 *
 */

class Model_Objectmap extends ORM {

   public static function configure_new_field($object_type_id, $field_name, $ui_type) {
      $map_entry = ORM::Factory('objectmap');
      $map_entry->objecttype_id = $object_type_id;
      $map_entry->type = self::field_type_forUI($ui_type);
      $map_entry->column = $field_name;
      $map_entry->index = self::next_index($object_type_id, $map_entry->type);
      $map_entry->save();
   }

   private static function next_index($object_type_id, $field_type) {
      
		$result = DB::select(array('index', 'max_index'))
              ->from('objectmaps')
              ->where('objecttype_id', '=', $object_type_id)
              ->where('type', '=', $field_type)
              ->order_by('index', 'DESC')
              ->limit(1, 0)
              ->execute()
              ->current();
      return $result['max_index'] + 1;
   }

   public static function field_type_forUI($ui_type) {
      $index = null;
      switch ($ui_type) {
         case 'text':
         case 'radio_group':
         case 'pulldown':
         case 'time':
         case 'date':
         case 'multi_select':
            $index = 'field';
            break;
         case 'image':
         case 'file':
            $index = 'file';
            break;
         case 'checkbox':
            $index = 'flag';
            break;
         default:
            $t_configs = lattice::config('objects', '//object_type');
            $object_types = array();
            foreach ($t_configs as $object_type) {
               $object_types[] = $object_type->get_attribute('name');
            }
            //print_r($object_types);
            if (in_array($ui_type, $object_types)) {
               $index = 'object';
            } else {
               return null;
            }
            break;
      }
      return $index;
   }

}

?>
