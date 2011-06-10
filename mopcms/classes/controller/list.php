<?

/*
 * This class should have it's API changed to respect calling via the Container object Id
 * The container object ID is actually the ID of the list object itself, currently we're addressing
 * lists by family name and parent id, which is actually redundant.
 */


/*
  Class: ListModule_Controller

 */

class Controller_List extends MOP_CMSInterface {
   /*
    *  Variable: page_id
    *  static int the global page id when operating within the CMS submodules get the page id
    *  we could just reference the primaryId attribute of Display as well...
    */

   private static $page_id = NULL;


   /*
     Variable: model
     Main model for items content managed by this class
    */
   protected $model = 'page';

   /*
    * Variable: containerObject
    * The parent object of the lists children
    */
   protected $_containerObject;
   protected $_family;

   
   protected $_listObject;
   protected $_itemView;
   
   
   
    
   /*
     Function:  construct();
     Parameters:
    */

   public function __construct($request, $response) {
      parent::__construct($request, $response);

   }
   
   
   protected function setListObject($listObjectIdOrParentId, $family=null) {

      if ($family != null) {
         $lt = ORM::Factory('template')->where('templatename', '=', $family)->find();

         $listObject = ORM::Factory('listcontainer')
                 ->where('parentid', '=', $listObjectIdOrParentId)
                 ->where('template_id', '=', $lt->id)
                 ->where('activity', 'IS', NULL)
                 ->find();

         if (!$listObject->loaded()) {
            throw new Kohana_Exception('Did not find list container List object is missing container: :id', array(':id' => $lt->id));
         }

         $this->_listObject = $listObject;
      } else {

         $this->_listObject = ORM::Factory('listcontainer', $listObjectIdOrParentId);
      }
      
      
      
   }
   
   protected function itemView(){
      
     if(!$this->_itemView){
      
     if(!$this->_listObject->loaded()){
        throw new Exception('listObject not set: controller must call setListObject before requesting itemView');
     }
     
      
      $customItemView = $this->_listObject->template->templatename . '_item';
      if (Kohana::find_file('views', $customItemView)) {
         $this->_itemView = $customitemView;
      } else {
         $this->_itemView = 'list_item';
      }
      
     }
     
     return $this->_itemView;
     
   
   }

   
   /*
    * Function: action_getList
    * Supports either calling with list object id directly, or with parentid and family 
    * for looking in database and config
    */
   
   public function action_getList($listObjectIdOrParentId, $family = null) {
      
      $this->setListObject($listObjectIdOrParentId, $family);
      

      $view = null;
      if (Kohana::find_file('views', $this->_listObject->template->templatename)) {
         $view = new View($this->_listObject->template->templatename);
      } else {
         $view = new View('list');
      }

      $listMembers = $this->_listObject->getChildren();

      $html = '';
      foreach ($listMembers as $object) {

         $htmlChunks = mopcms::buildUIHtmlChunksForObject($object);
         $itemt = new View($this->itemView());
         $itemt->uiElements = $htmlChunks;

         $data = array();
         $data['id'] = $object->id;
         $data['page_id'] = $this->_listObject->id;
         $data['instance'] = $this->_listObject->template->templatname;
         $itemt->data = $data;

         $html.=$itemt->render();
      }

      //actually we need to do an absolute path for local config
      $listConfig = $this->_listObject->getConfig();
      $view->label = $listConfig->getAttribute('label');
      $view->class = $listConfig->getAttribute('cssClasses');
      $view->class .= ' allowChildSort-' . $listConfig->getAttribute('allowChildSort');
      $view->class .= ' sortDirection-' . $this->_listObject->getSortDirection();
      $view->items = $html;
      $view->instance = $this->_listObject->template->templatname;
      $view->listObjectId = $this->_listObject->id;


      $this->response->body($view->render());
   }

   //this is the new one
   public function action_savefield($itemid) {
      $object = ORM::Factory($this->model, $itemid);
      $object->contenttable->$_POST['field'] = $_POST['value'];
      $object->contenttable->save();
      $this->response->data( array('value' => $object->contenttable->$_POST['field']) );
   }

   /*
     Function: addItem()
     Adds a list item

     Returns:
     the rendered template of the new item
    */

   public function action_addObject($listObjectId, $templateId=null) {
      
      $this->setListObject($listObjectId);

      //addable item should be specifid in the addItem call
      if($templateId == null){
   
        $template = mop::config('objects', sprintf('//list[@family="%s"]/addableObject', $this->_listObject->template->templatename));
        if (!$template->length > 0) {
           throw new Kohana_Exception('No List By That Name' .' Count not locate configuration in objects.xml for ' . sprintf('//list[@family="%s"]/addableobject', $this->_family));
        }
        $addObjectTemplateId = $template->item(0)->getAttribute('templateName');

      } else {
        
         $addObjectTemplateId = $templateId;
      
      }

      $data = array('published' => 'true');

      
      $newid = mopcms::addObject($listObjectId, $addObjectTemplateId, $data);

      $item = ORM::Factory('page', $newid);
      $htmlChunks = mopcms::buildUIHtmlChunksForObject($item);
      $itemt = new View($this->itemView());
      $itemt->uiElements = $htmlChunks;

      $data = array();
      $data['id'] = $newid;
      $data['page_id'] = $listObjectId;
      ;
      $data['instance'] = $this->_listObject->template->templatename;


      $itemt->data = $data;

      $html = $itemt->render();

      $this->response->body($html);
    }

 
}

?>
