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
class View_Csv  {
   
   private $_indent = 0;
   private $_data = 0;
   private $_objectTypeName;
   
   public function __construct($indent, $object){
       $this->$_indent = $indent;
       $this->$_data = $object->getPathContent();
       $this->$_objectTypeName = $object->objecttype->objecttypename;
   }
   
   public function render(){
      $objectTypeLine = array_pad(array(), $indent, '') + array($this->_objectTypeName);
      $csv = latticeutil::arrayToCsv($objectTypeLine);
      $csv .= "\n";
      
      foreach($this->$_data as $columnName => $dataItem){
         $dataItemLine = array_pad(array(), $indent+1, '') + array($columnName, $dataItem);
         $csv .= latticeutil::arrayToCsv($dataItemLine);
         $csv .= "\n";
      }
      
      return $csv;
      
   }
   
}

?>
