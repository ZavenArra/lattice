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
class View_CsvContainer {

   private $_indent = 0;
   private $_object = 0;
   private $_objectTypeName = '';
   private $skipFields = array('slug', 'id', 'dateadded', 'objecttypename');

   public function __construct($indent, $object) {
      $this->_indent = $indent;
      $this->_object = $object;
      $this->_objectTypeName = $object->objecttype->objecttypename;
   }

   public function render() {

      $objectTypeLine = array_pad(array($this->_objectTypeName), -1 - $this->_indent, '');
      $csv = latticeutil::arrayToCsv($objectTypeLine, ',');
      $csv .= "\n";

			return $csv;
   }
}

?>
