<?

/*
 * This class should have it's API changed to respect calling via the Container object Id
 * The container object ID is actually the ID of the list object itself, currently we're addressing
 * lists by family name and parent id, which is actually redundant.
 */


/*
  Class: ListModule_Controller

 */

class Controller_List extends Lattice_CMSInterface {
   /*
    *  Variable: object_id
    *  static int the global object id when operating within the CMS submodules get the object id
    *  we could just reference the primaryId attribute of Display as well...
    */

   private static $object_id = NULL;


   /*
     Variable: model
     Main model for items content managed by this class
    */
   protected $model = 'object';

   /*
    * Variable: containerObject
    * The parent object of the lists children
    */
   protected $_containerObject;
   protected $_family;

   
   protected $_listObject;
   
   
   
    
   /*
     Function:  construct();
     Parameters:
    */

   public function __construct($request, $response) {
      parent::__construct($request, $response);

   }
   
   
   protected function setListObject($listObjectIdOrParentId, $family=null) {
      if ($family != null) {
				$parentId = $listObjectIdOrParentId;

				$listContainerObject = Graph::object($parentId)->$family;


         if (!$listContainerObject->loaded()) {
            throw new Kohana_Exception('Did not find list container List object is missing container: :id', array(':id' => $lt->id));
         }

         $this->_listObject = $listContainerObject;

      } else {

         $this->_listObject = ORM::Factory('listcontainer', $listObjectIdOrParentId);
      }
      
      if(!$this->_listObject->loaded()){
         throw new Kohana_Exception('Failed to load list object');
      }
      
   }
   
   
   /*
    * Function: action_getList
    * Supports either calling with list object id directly, or with parentId and family 
    * for looking in database and config
    */
   
   public function action_getList($listObjectIdOrParentId, $family = null) {
      
      $this->setListObject($listObjectIdOrParentId, $family);
 
      //throw new Kohana_Exception('what');

      $view = null;
			$customListView = 'objectTypes/'.$this->_listObject->objecttype->objecttypename;
      if (Kohana::find_file('views', $customListView)) {
         $view = new View($customListView);
      } else {
         $view = new View('list');
      }

      $listMembers = $this->_listObject->getChildren();

      $html = '';
      foreach ($listMembers as $object) {

         $htmlChunks = latticecms::buildUIHtmlChunksForObject($object);

         $customItemView = 'objectTypes/' . $object->objecttype->objecttypename;
         $itemView = null;
         if (Kohana::find_file('views', $customItemView)) {
            $itemView = new View($customItemView);
            $this->loadResourcesForKey($customItemView);
            foreach($htmlChunks as $key=>$value){
               $itemView->$key = $value;
            }
         } else {
            $itemView = new View('list_item');
         }


         $itemView->uiElements = $htmlChunks;

         $data = array();
         $data['id'] = $object->id;
         $data['object_id'] = $this->_listObject->id;
         $data['instance'] = $this->_listObject->objecttype->templatname;
         $itemView->data = $data;

         $html.=$itemView->render();
      }
      

      //actually we need to do an absolute path for local config
      $listConfig = $this->_listObject->getConfig();
      $view->label = $listConfig->getAttribute('label');
      $view->class = $listConfig->getAttribute('cssClasses');
      $view->class .= ' allowChildSort-' . $listConfig->getAttribute('allowChildSort');
      $view->class .= ' sortDirection-' . $this->_listObject->getSortDirection();
      $view->items = $html;
      $view->instance = $this->_listObject->objecttype->templatname;
			$view->addableObjects = $this->_listObject->objecttype->addableObjects;
      $view->listObjectId = $this->_listObject->id;


      $this->response->body($view->render());
   }

   //this is the new one
   public function action_savefield($itemid) {
      $object = ORM::Factory($this->model, $itemid);
      $object->$_POST['field'] = $_POST['value'];
      $object->save();
      $this->response->data( array('value' => $object->$_POST['field']) );
   }

   /*
     Function: addItem()
     Adds a list item

     Returns:
     the rendered objectType of the new item
    */

   public function action_addObject($listObjectId, $objectTypeId=null) {
 
      
      $this->setListObject($listObjectId);  //This function should be removed
                                                     //and all functionality simply moved to the model.

           
      $listObject = ORM::Factory('listcontainer', $listObjectId);


      //addable item should be specifid in the addItem call
      if($objectTypeId == null){
   
        $addableObjectTypes = lattice::config('objects', sprintf('//list[@name="%s"]/addableObject', $listObject->objecttype->objecttypename));
        if (!$addableObjectTypes->length > 0) {
           throw new Kohana_Exception('No Addable Objects ' .' Count not locate configuration in objects.xml for ' . sprintf('//list[@name="%s"]/addableobject', $this->_family));
        }
        $objectTypeId = $addableObjectTypes->item(0)->getAttribute('objectTypeName');
      } 
 
      $newId = $listObject->addObject($objectTypeId);
      
      $item = Graph::object($newId);
      $htmlChunks = latticecms::buildUIHtmlChunksForObject($item);

			$customItemView = 'objectTypes/'.$item->objecttype->objecttypename;
			$itemView = null;
			if (Kohana::find_file('views', $customItemView)) {
				$itemView = new View($customItemView);
			} else {
				$itemView = new View('list_item');
			}


      $itemView->uiElements = $htmlChunks;

      $data = array();
      $data['id'] = $newId;
      $data['object_id'] = $listObjectId;
      ;
      $data['instance'] = $this->_listObject->objecttype->objecttypename;


      $itemView->data = $data;

      $html = $itemView->render();

      $this->response->body($html);
    }

 
}

?>
