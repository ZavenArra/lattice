<?
/**
 * Class: CMS_Intergace_Controller
 * The main CMS class, handling add, delete, and retrieval of pages
 * @author Matthew Shultz
 * @version 1.0
 * @package Kororor
 */

abstract class MOP_CMSInterface extends Controller_Layout {


	/*
		Function: __constructor
		Loads subModules to build from config	
	*/
	public function __construct($request, $response){
    	parent::__construct($request, $response);
	}

	/*
	 * Function:  saveFile($objectId)
	 * Function called on file upload
	 * Parameters:
	 * pageid  - the page id of the object currently being edited
	 * $_POST['field'] - the content table field for the file
	 * $_FILES[{fieldname}] - the file being uploaded
	 * Returns:  array(
		 'id'=>$file->id,
		 'src'=>$this->basemediapath.$savename,
		 'filename'=>$savename,
		 'ext'=>$ext,
		 'result'=>'success',
	 );
	 */
	public function action_saveFile($objectId){

		list($cookieName, $cookieValue) = str_split('=', $_GET['cookie']);

		session_name($cookieName);
		session_id($cookieValue);

		session_start();

		$file = mopcms::saveHttpPostFile($objectId, $_POST['field'], $_FILES[$_POST['field']]);
		$result = array(
			'id'=>$file->id,
			'src'=>$file->original->fullpath,
			'filename'=>$file->filename,
			'ext'=>$file->ext,
			'result'=>'success',
		);	
		
		//if it's an image
		$thumbSrc = null;
		if($file->uithumb->filename){
			if(file_exists(Graph::mediapath().$file->uithumb->filename)){
				$resultpath = Graph::mediapath().$file->uithumb->filename;
				$thumbSrc = Kohana::config('cms.basemediapath').$file->uithumb->filename;
			}
		}
		if($thumbSrc){
			$size = getimagesize($resultpath);
			$result['width'] = $size[0];
			$result['height'] = $size[1];
			$result['thumbSrc']= $thumbSrc;
		}

    $this->response->data($result);

	}

	public function action_clearField($objectId, $field){
		$object = Graph::object($objectId);
		if(Graph::isFileModel($object->contenttable->$field) && $object->contenttable->$field->loaded()){
			$file = $object->contenttable->$field;
			$file->delete(); //may or may not want to do this
		}
		$object->contenttable->$field = null;
      $return = array('cleared'=>'true');
      $this->response->data($return);
	}

	/*
	*
	* Function: savefield()
	* Saves data to a field via ajax.  Call this using /cms/ajax/save/{pageid}/
	* Parameters:
	* $id - the id of the object currently being edited
	* $_POST['field'] - the content table field being edited
	* $_POST['value'] - the value to save
	* Returns: array('value'=>{value})
	 */
	public function action_savefield($id){
      $object = Graph::object($id);
      $object->$_POST['field'] = $_POST['value'];
			$object->save();
      $object = Graph::object($id);
      $value = $object->$_POST['field'];
      
      $returnData = array('value'=>$value);
      if($_POST['field']=='title'){
         $returnData['slug'] = $object->slug;
      }
      $this->response->data($returnData);
	}



	/*
		Function: togglePublish
		Toggles published / unpublished status via ajax. Call as cms/ajax/togglePublish/{id}/
		Parameters:
		id - the id to toggle
		Returns: Published status (0 or 1)
		*/
		public function action_togglePublish($id){
			$object = ORM::Factory('object')->where('id', '=', $id)->find();
			if($object->published==0){
				$object->published = 1;
			} else {
				$object->published = 0;
			}
			$object->save();

			$this->response->data( array('published' => $object->published) );
		}

		/*
		Function: saveSortOrder
		Saves sort order of some ids
		Parameters:
		$_POST['sortorder'] - array of page ids in their new sort order
		*/
		public function action_saveSortOrder(){
			$order = explode(',', $_POST['sortorder']);

			for($i=0; $i<count($order); $i++){
				if(!is_numeric($order[$i])){
					throw new Kohana_User_Exception('bad sortorder string', 'bad sortorder string');
				}
				$object = ORM::factory('object', $order[$i]);
				$object->sortorder = $i+1;
				$object->save();
			}

			$this->response->data( array('saved'=>true));
		}

      
      public function action_addTag($id, $tag){
         $object = ORM::Factory('object', $id);
         $object->addTag($tag);
         
      }

      public function action_removeTag($id, $tag){
         $object = ORM::Factory('object', $id);
         $object->removeTag($tag);
      }
      
      public function action_getTags($id){
 
        $tags = ORM::Factory('object', $id)->getTags();
        $this->response->data(array('tags'=>$tags));
      }

      
      
		/*
		 Function: delete
		 deletes a page/category and all categories and leaves underneath
		 Returns: returns html for undelete pane 
		*/
		public function action_removeObject($id){
			$this->cascade_delete($id);

			$view = new View('mop_cms_undelete');
			$view->id=$id;
         $this->response->body($view->render());
         $this->response->data(array('deleted'=>true));

		}


		/*
		 Function: undelete
		 Undeletes a page/category and all categories and leaves underneath

		 Returns: 1;
		*/
		public function action_undelete($id) {
			$this->cascade_undelete($id);
			//should return something about failure...
			$this->response->data( array('undeleted'=>true) );

		}

	
	/*
	 * Function: cascade_delete($id)
	 * Private utility to recursively delete and object and everything beneath a node
	 * Parameters:
	 * id - the id to delete as well as everything beneath it.
	 * Returns: nothing 
	 */
	protected function cascade_delete($id){
		$object = ORM::Factory('object')->where('id', '=', $id)->find();
		$object->activity = 'D';
		$object->sortorder = 0;
		$object->slug = DB::expr('null');
		$object->save();
		$object->contenttable->activity = 'D';
		$object->contenttable->save();

		$children = ORM::Factory('object');
		$children->where('parentId', '=',$id);
		$iChildren = $children->find_all();
		foreach($iChildren as $child){
			$this->cascade_delete($child->id);
		}
	}

	/*
	 * Function: cascade_undelete($id)
	 * Private utility to recursively undelete and object and everything beneath a node
	 * Parameters:
	 * id - the id to undelete as well as everything beneath it.
	 * Returns: Nothing
	 */
	protected function cascade_undelete($object_id){
		$object = ORM::Factory('object')->where('id', '=', $id)->find();
		$object->activity = new Database_Expression(null);
		$object->slug = mopcms::createSlug($object->contenttable->title, $object->id);
		$object->save();
		$object->contenttable->activity = new Database_Expression(null);
		$object->contenttable->save();

		$children = ORM::Factory('object');
		$children->where('parentId','=',$id);
		$iChildren = $children->find_all();
		foreach($iChildren as $child){
			$this->cascade_undelete($child->id);
		}

	}

   //abstract
   protected function cms_getNode($id){
   }

   //abstract
   protected function cms_addObject($parentId, $templateId, $data) { 
   }


}

?>
