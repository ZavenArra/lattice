<?

class Controller_CMS extends MOP_CMS {

  
   public function cms_addObject($parentId, $templateId, $data) {
         
		$newid = Graph::object($parentId)->addObject($templateId, $data);
      return $newid;

   }
   
   public function cms_getNode($id){
      
      //Dial up associated navi and ask for details
		return Navigation::getNodeInfoById($id);
      
   }
  
}
