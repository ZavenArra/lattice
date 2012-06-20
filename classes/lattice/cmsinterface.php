<?

/**
 * Class: CMS_Intergace_Controller
 * The main CMS class, handling add, delete, and retrieval of objects
 * @author Matthew Shultz
 * @package Lattice
 */
abstract class Lattice_CMSInterface extends Controller_Layout {


    public function __construct($request, $response){
      parent::__construct($request, $response);
    }


   /*
    * Function:  saveFile($objectId)
    * Function called on file upload
    * Parameters:
    * objectid  - the object id of the object currently being edited
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

   public function action_savefile($objectId) {

      try {

         $this->savefile($objectId);

      } catch (Exception $e) {

         //return the model errors gracecully;

         $this->handleDataException($e);

      }
   }

   public function savefile($objectId) {

      $field = strtok($_POST['field'], '_');

      $file = latticecms::saveHttpPostFile($objectId, $field, $_FILES['Filedata']);
      $result = array(
          'id' => $file->id,
          'src' => $file->original->fullpath,
          'filename' => $file->filename,
          'ext' => $file->ext,
          'result' => 'success',
      );

      //if it's an image
      $thumbSrc = null;
      if ($file->uithumb->filename) {
         if (file_exists(Graph::mediapath() . $file->uithumb->filename)) {
            $resultpath = Graph::mediapath() . $file->uithumb->filename;
            $thumbSrc = $resultpath; //Kohana::config('cms.basemediapath') . $file->uithumb->fullpath;
         }
      }
      if ($thumbSrc) {
         $size = getimagesize($resultpath);
         $result['width'] = $size[0];
         $result['height'] = $size[1];
         $result['thumbSrc'] = $thumbSrc;
      }

      $this->response->data($result);
   }

   public function action_clearField($objectId, $field) {

      $object = Graph::object($objectId);
      if (Graph::isFileModel($object->$field) && $object->$field->loaded()) {
         $file = $object->$field;
         $file->delete();
      }
      $object->$field = null;
      $return = array('cleared' => 'true');
      $this->response->data($return);
   }

   /*
    *
    * Function: action_savefield()
    * Saves data to a field via ajax.  Call this using /cms/ajax/save/{objectid}/
    * Parameters:
    * $id - the id of the object currently being edited
    * $_POST['field'] - the content table field being edited
    * $_POST['value'] - the value to save
    * Returns: array('value'=>{value})
    */

   public function action_savefield($id) {

      try {

         $this->savefield($id);
      } catch (Exception $e) {

         //return the model errors gracecully;

         $this->handleDataException($e);
      }
   }

   /*
    *
    * Function: _savefield()
    * Saves data to a field via ajax.  Call this using /cms/ajax/save/{objectid}/
    * Parameters:
    * $id - the id of the object currently being edited
    * $_POST['field'] - the content table field being edited
    * $_POST['value'] - the value to save
    * Returns: array('value'=>{value})
    */

   public function savefield($id) {

      //$field = strtok($_POST['field'], '_');
      $field = $_POST['field'];
      

      $object = Graph::object($id);
      $object->$field = $_POST['value'];
      $object->save();

      $returnData = array();
      if (count($object->getMessages())) {
         $returnData['messages'] = $object->getMessages();
      }

      $object = Graph::object($id);
      $value = $object->$field;

      $config = $object->getElementConfig($field);

			$returnData['value'] = $value;

      if ($_POST['field'] == 'title') {
         $returnData['slug'] = $object->slug;
      }
      $this->response->data($returnData);
   }

   public function action_move($objectId, $newParentId, $lattice='lattice', $oldParentId=NULL){
      $object = Graph::object($objectId);
      $object->move($newParentId, $lattice, $oldParentId);
      $this->response->data(array('newParentId', $object->getLatticeParent($lattice)->id));
   }


   /*
    * Function: handleDataException();
    */

   protected function handleDataException($e) {

			if(get_class($e) != 'ORM_Validation_Exception'){
				throw $e;
			}
      $modelErrors = $e->errors('validation');

      if (isset($modelErrors['_external'])) {
         $modelErrors = array_values($modelErrors['_external']);
      }

      $firstkey = array_keys($modelErrors);
      $firstkey = $firstkey[0];

      $return = $this->response->data(array('value' => NULL, 'error' => 'true', 'message' => $modelErrors[$firstkey]));
   }

   /*
     Function: togglePublish
     Toggles published / unpublished status via ajax. Call as cms/ajax/togglePublish/{id}/
     Parameters:
     id - the id to toggle
     Returns: Published status (0 or 1)
    */

   public function action_togglePublish($id) {
      $object = Graph::object($id);
      if ($object->published == 0) {
         $object->published = 1;
      } else {
         $object->published = 0;
      }
      $object->save();

      $this->response->data(array('published' => $object->published));
   }

   /*
     Function: saveSortOrder
     Saves sort order of some ids
     Parameters:
     $_POST['sortOrder'] - array of object ids in their new sort order
    */

   public function action_saveSortOrder($parentId, $lattice='lattice') {

      $order = explode(',', $_POST['sortOrder']);
      $object = ORM::Factory('object', $parentId);
      $object->setSortOrder($order, $lattice);



      $this->response->data(array('saved' => true));
   }

   public function action_addTag($id) {
      $object = Graph::object($id);
      $object->addTag($_POST['tag']);
   }

   public function action_removeTag($id) {
      $object = Graph::object($id);
      $object->removeTag($_POST['tag']);
   }

   public function action_getTags($id) {

      $tags = Graph::object($id)->getTagStrings();
      $this->response->data(array('tags' => $tags));
   }

   /*
     Function: delete
     deletes a object/category and all categories and leaves underneath
     Returns: returns html for undelete pane
    */
   public function action_removeObject($id) {
     $object = Graph::object($id);
     $object->deactivate($id);

      $view = new View('lattice_cms_undelete');
      $view->id = $id;
      $this->response->body($view->render());
      $this->response->data(array('deleted' => true));
   }

   /*
     Function: undelete
     Undeletes a object/category and all categories and leaves underneath

     Returns: 1;
    */
   public function action_undelete($id) {
     $object = Graph::object($id);
     $object->reactivate($id);
     $this->response->data(array('undeleted' => true));
   }

   public function action_associate($parentId, $objectId, $lattice){
     $parent = Graph::object($parentId);
     $parent->addLatticeRelationship($objectid, $lattice);
     $metaObjectType = $parent->getMetaObjectType($lattice);
   }

   public function action_disassociate($parentId, $objectId, $lattice){
      Graph::object($parentId)->removeLatticeRelationship($objectid, $lattice);
   }
   
   public function action_toggleUserAssociation($objectId) {
     //get user and object from post
     $userId = $_POST["field"];
     $toggleState = $_POST["value"];
     //check user is valid or bail
     $userCheck =   ORM::factory('user',$userId);
     if (!$userCheck->loaded()){
 			 $this->response->data(array('error'=>true,'message'=>'User does not exist'));
     } else {
       //if the toggle 
      if ($toggleState==0){
        $o = ORM::factory('objects_user')
        ->where('object_id','=',$objectId)
        ->where('user_id','=',$userId);
        $results = $o->find_all();
        foreach($results as $result) {
          $result->delete();
        }
  			$this->response->data( array('value'=>$_POST["value"]) );
      } else {
        //the association doesn't exist so create it  
        $o = ORM::factory('objects_user');
        $o->user_id = $userId;
        $o->object_id = $objectId;
        $o->save();
  		  $this->response->data( array('value'=>$_POST["value"]) );
      }  
    }
  }
   
   public function action_associateuser($userId, $objectId) {
      //check 
    $userCheck =   ORM::factory('user',$userId);
    $existsCheck = ORM::factory('objects_user')
    ->where('object_id','=',$objectId)
    ->where('user_id','=',$userId)->find();
    if ($userCheck->loaded() && (!$existsCheck->loaded())){
      $o = ORM::factory('objects_user');
      $o->user_id = $userId;
      $o->object_id = $objectId;
      $o->save();
      echo json_encode(TRUE);
    } else {
      echo json_encode(FALSE);
    }
   }



   //abstract
   protected function cms_getNode($id) {
      
   }

   //abstract
   protected function cms_addObject($parentId, $objectTypeId, $data) {
      
   }
   
   
 	 public function action_getChildrenPaged($id,$pageNum) {
     $object = Graph::object($id);
     $object->setPageNum($pageNum);
//     $object->setItemsPerPage(2);
     $ret = $object->latticeChildrenFilterPaged($id,"lattice");
   }
}

?>
