<?php

/*
 * To change this objectType, choose Tools | Templates
 * and open the objectType in the editor.
 */

/**
 * Description of listcontainer
 *
 * @author deepwinter1
 */
class Model_ListContainer extends Model_Object {

   protected $_has_one = array(
       'objecttype' => array('foreign_key'=>'objecttype_id')
   );
   
   private $_sortDirection = null;
   
   protected $_table_name = 'objects';
   protected $_xmlConfig = null;
   
	public function __construct($id){
		parent::__construct($id);


	}

   public function getSortDirection(){
      
      if(!$this->_sortDirection){
          $this->_sortDirection = lattice::config('objects', sprintf('//list[@name="%s"]', $this->objecttype->objecttypename))->item(0)->getAttribute('sortDirection');   
      }
      
      return $this->_sortDirection;
   }
   
   public function getConfig(){
      if(!$this->_xmlConfig) {
         $xPathLookup = sprintf('//list[@name="%s"]', $this->objecttype->objecttypename);
         $this->_xmlConfig = lattice::config('objects', $xPathLookup)->item(0);
         if (!$this->_xmlConfig) {
            throw new Kohana_Exception('Failed to find xPath config in objects.xml :lookup', array(':lookup' => $xPathLookup));
         }
      }
      return $this->_xmlConfig;
   }

	
   public function addObject($objectTypeName, $data = array(), $lattice = null, $rosettaId = null, $languageId = null) {
      $data['published'] = 'true';
      return parent::addObject($objectTypeName, $data, $lattice, $rosettaId, $languageId);
   }

}
?>
