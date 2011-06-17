<?

class Controller_CMS extends MOP_CMS {

  
   public function cms_addObject($parentId, $templateId, $data) {
         
		$newId = Graph::object($parentId)->addObject($templateId, $data);
      return $newId;

   }
   
   public function cms_getNode($id){
      
      //Dial up associated navi and ask for details
		return Navigation::getNodeInfoById($id);
      
   }
  
}
