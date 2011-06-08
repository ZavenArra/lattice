<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of listcontainer
 *
 * @author deepwinter1
 */
class Model_ListContainer extends Model_Object {

   private $_sortDirection = null;
   
   protected $_table_name = 'pages';
   protected $_xml_config = null;
   
   public function getSortDirection(){
      
      if(!$this->_sortDirection){
          $this->_sortDirection = mop::config('objects', sprintf('//list[@family="%s"]', $this->template->templatename))->item(0)->getAttribute('sortDirection');   
      }
      
      return $this->_sortDirection;
   }
   
   public function getConfig(){
      if (!$this->_xml_config) {
         $xPathLookup = sprintf('//list[@family="%s"]', $this->template->templatename);
         $this->_xml_config = mop::config('objects', $xPathLookup)->item(0);
         if(!$this->_xml_config){
              throw new Kohana_Exception('Failed to find xPath config in objects.xml :lookup', array(':lookup'=>$xPathLookup));
         }
      }
      return $this->_xml_config;
   }
}
?>
