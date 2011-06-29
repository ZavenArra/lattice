<?

class Controller_CMS extends MOP_CMS {

  
   public function cms_addObject($parentId, $templateId, $data) {
         
		 $newId = Graph::object($parentId)->addObject($templateId, $data);
		 return $newId;

   }
   
   public function cms_getNodeInfo($id){
      
		 //Dial up associated navi and ask for details
		 return Navigation::getNodeInfoById($id);

   }
   
   public function cms_getNodeHtml($id){
      
		 //Dial up associated navi and ask for details
      $item = Navigation::getNodeInfoById($id);
		$nodeView = new View('navigationNode');
		$nodeView->content = $item;
		return $nodeView->render();

   }
  
}
