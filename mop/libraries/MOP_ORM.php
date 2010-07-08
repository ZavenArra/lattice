<?php defined('SYSPATH') or die('No direct script access.');
/**
 * ORM extended for KOROROROR
 *
 * @package    Core
 * @author     DEEPWINTER
 * @copyright  (c) 2007-2008 Kohana Team
 * @license    http://kohanaphp.com/license.html
 */
 class MOP_ORM_Core extends ORM_Core { 

	 /*
		* Variable: usedb
		* The db settings record to use from database.php config file
		*/
	 protected static $usedb = 'default';

	 /*
		 Function: __initialize
		 Custom constructor allows setting of database settings to use for an object
		 based on public static set vi setDB()
		*/
	 public function __initialize(){
		 $this->db = ORM::$usedb;
		 parent::__initialize();

	 }

	 /*
		* Function: factory
		* Custom extentions to factory class from ORM_Core, to allow for virtual classes
		* Creates and returns a new model.
		* Parameters: 
		* $model - the name of the model to build, in most cases a table in the database
		* $id - an optional id of a record to load while initializing
		* Returns: A completed ORM model for the given table
		*/
	 public static function factory($model, $id = NULL)
	 {
		
		 //Make sure the model class is defined
		 $includemodel = ucfirst($model).'_Model';
		 if(!class_exists($includemodel)){
			 //create model class
			 //use of eval, but i don't think there's another way to do this
			 $includeclass = "class $includemodel extends ORM { } ";
			 eval($includeclass);
		 }

		 return ORM_Core::factory($model, $id);
	 }

	 /*
	 Function: setDB($db)
	 set a custom database connection handle to reference site-wide
	 Parameters:
	 $db - the key to look for in database.php for dbsettings
	 */
	 public static function setDB($db){
			ORM::$usedb = $db;
	 }

	 /*
		* Function : setTemplateName
		* We use dbmapping sometimes in cms, this is a placeholder function so that tables
		* without dbmapping can be used by cms
		* Parameters:
		* $tempaltename - the templatename
		*/
	 public function setTemplateName($templatename){
		//do notihing
	 }

	 /*
		* Function: __clone()
		* Custom function to clone an object, causes the db connection to be cloned
		* Parameters: none
		* Returns: nothing
		*/
	 public function __clone(){
		 $this->db = clone $this->db;	
	 }

	 /*
		* Function: getTableColumns()
		* Convienient function to get the columns of the table being referenced by this model
		* Parameters: none
		* Returns: array of table columns
		*/
	 public function getTableColumns(){
		 return array_keys($this->table_columns);
	 }

}

