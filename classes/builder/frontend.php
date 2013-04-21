<?

Class Builder_Frontend {

	private $basePath = 'application/views/generated/';

	public function __construct(){
		if(!is_writable($this->basePath)){
			die($this->basePath.' must be writable');
		}
	}

  public function index(){
    echo "Configuring Frontend\n";
    echo "Reading application/config/frontend.xml\n";

    lattice::config('objects', '//objectTypes');

    flush();
    ob_flush();
    flush();

    $createdViews = array();
    //	foreach(lattice::config('frontend', '//view') as $view ){
    //	//this has removed the ability to build virtual views
    foreach(lattice::config('objects', '//objectType') as $objectType){
      $view = lattice::config('frontend', '//view[@name="'.$objectType->getAttribute('name').'"]');
      if(count($view)){
        $view = $view->item(0);
      }
      if($view){
        $viewName = $view->getAttribute('name');
      } else {
        $viewName = $objectType->getAttribute('name');
      }

      echo $viewName."\n";
      flush();
      ob_flush();
      flush();

      ob_start();
      if(!$view ||  ($view && $view->getAttribute('loadPage')=='true')){
        echo "<h1><?=\$content['main']['title'];?></h1>\n\n";
        //this also implies that name is a objecttypename
        foreach(lattice::config('objects', 
          sprintf('//objectType[@name="%s"]/elements/*', $viewName )) as $element){

           switch($element->tagName){
           case 'list':
             $this->makeListDataHtml($element, "\$content['main']");
             break;
           case 'associator':
             $this->makeAssociatorDataHtml($element, "\$content['main']");
             break;
           default:
             frontend::makeHtmlElement($element, "\$content['main']");
             break;
           }

      }

      if($view && $view->getAttribute('loadPage')=='true'){

        //Now the includeData
        if($iDataNodes = lattice::config('frontend',"//view[@name=\"".$view->getAttribute('name')."\"]/includeData")){
          foreach($iDataNodes as $iDataConfig){
            $prefix = "\$content";
            $this->makeIncludeDataHtml($iDataConfig, $prefix, null);
          }
        }

        if($subviews = lattice::config('frontend',"//view[@name=\"".$view->getAttribute('name')."\"]/subview")){
          foreach($subviews as $subviewConfig){
            echo "\n<?=\$".$subviewConfig->getAttribute('label').";?>\n";
          }
        }

      }



      $html = ob_get_contents();
      ob_end_clean();
      $file = fopen($this->basePath.$viewName.'.php', 'w');
      fwrite($file, $html);
      fclose($file);

      $createdViews[] = $viewName;
    }
    }

    echo 'Completed all basic object views' . "\n";
    flush();
    ob_flush();
    flush();

    //and any virtual views
    foreach(lattice::config('frontend', '//view') as $viewConfig){
      $viewName = $viewConfig->getAttribute('name');

      if( in_array($viewName, $createdViews)){
        continue;
      }
      echo 'Virtual View: '.$viewName . "\n";
      flush();
      ob_flush();
      flush();


      touch($this->basePath.$viewName.'.php');

      ob_start();
      //Now the includeData

      if($iDataNodes = lattice::config('frontend',"//view[@name=\"".$viewName."\"]/includeData")){
        foreach($iDataNodes as $iDataConfig){
          $prefix = "\$content";
          $this->makeIncludeDataHtml($iDataConfig, $prefix, null);
        }
      }

      if($subviews = lattice::config('frontend',"//view[@name=\"".$viewName."\"]/subview")){
        foreach($subviews as $subviewConfig){
          echo "\n<?=\$".$subviewConfig->getAttribute('label').";?>\n";
        }
      }


      $html = ob_get_contents();
      ob_end_clean();
      $file = fopen($this->basePath.$viewName.'.php', 'w');
      fwrite($file, $html);
      fclose($file);
    }



    echo "Done\n";
  }

  public function makeListDataHtml($listDataConfig, $prefix, $indent = ''){
    $objectTypes = array();
    foreach (lattice::config('objects', 'addableObject', $listDataConfig) as $addable) {
      $objectTypeName = $addable->getAttribute('objectTypeName');
      $objectTypes[$objectTypeName] = $objectTypeName;
    }

    $this->makeMultiObjectTypeLoop($objectTypes, $listDataConfig->getAttribute('name'),  $prefix, $indent);

   }

  //TODO: This doesn't currently support filter types that don't declare objecTypeNames or 
  //nor with multiple objectTypeNames per filter
  public function makeAssociatorDataHtml($associatorDataConfig, $prefix, $indent = ''){
    $objectTypes = array();
    $filters = lattice::config('objects', 'filter', $associatorDataConfig);
    foreach($filters as $filter){
      if($filter->getAttribute('objectTypeName')){
        $objectTypes[] = $filter->getAttribute('objectTypeName');
      }
    }

    $this->makeMultiObjectTypeLoop($objectTypes, $associatorDataConfig->getAttribute('name'),  $prefix, $indent);
  }


	public function makeIncludeDataHtml($iDataConfig, $prefix, $parentTemplate, $indent=''){
		$label = $iDataConfig->getAttribute('label');
     
      
		$objectTypes = array();
		//if slug defined, get objectType from slug
		if($slug = $iDataConfig->getAttribute('slug')){
			$object = Graph::object($slug);
			if(!$object->loaded()){
				//error out,
				//object must be loaded from data.xml for this type of include conf
			}
			$objectTypes[] = $object->objecttype->objecttypename;
		}
		if(!count($objectTypes)){
			$objectTypes = $iDataConfig->getAttribute('objectTypeFilter');
			if($objectTypes!='all'){
				$objectTypes = explode(',', $objectTypes);
			} else {
				$objectTypes = array();
			}
		}

		if(!count($objectTypes)){
			//no where for objectTypes
			//assume that we'll have to make a good guess based off 'from' parent
			$from=$iDataConfig->getAttribute('from');
			if($from=="parent"){

				//get the info from addableObjects of the current
				foreach(lattice::config('objects', sprintf('//objectType[@name="%s"]/addableObject', $parentTemplate)) as $addable){
					$objectTypeName = $addable->getAttribute('objectTypeName');
					$objectTypes[$objectTypeName] = $objectTypeName;
				}

				//and we can also check all the existing data to see if it has any other objectTypes
				$parentObjects = Graph::object()->objecttypeFilter($parentTemplate)->publishedFilter()->find_all();
				foreach($parentObjects as $parent){
					$children = $parent->getPublishedChildren();
					foreach($children as $child){
						$objectTypeName = $child->objecttype->objecttypename;
						$objectTypes[$objectTypeName] = $objectTypeName;
					}
				}
      } else if ($from=="root"){
        $objectTypesFromParent = $this->getChildrenObjectTypes( Object::getRootNode( Kohana::config('cms.graphRootNode') ) );
        $objectTypes = array_merge($objectTypes, $objectTypesFromParent);
      } else {
        //see if from is a slug
        $objectTypesFromParent = $this->getChildrenObjectTypes(Graph::object($from));
        $objectTypes = array_merge($objectTypes, $objectTypesFromParent);
			}
		}	

     // now $objectTypes contains all the needed objectTypes in the view
		

      $this->makeMultiObjectTypeLoop($objectTypes, $label, $prefix, $indent, $iDataConfig);
   }
   
   protected function makeMultiObjectTypeLoop($objectTypes, $label, $prefix, $indent='', $frontendNode=NULL ){
      echo $indent."<h2>$label</h2>\n\n";
		echo $indent."<ul id=\"$label\" >\n";
		$doSwitch = false;


		if(count($objectTypes)>1){
			$doSwitch = true;
		}

		echo $indent."<?foreach({$prefix}['$label'] as \${$label}Item):?>\n";
		if($doSwitch){
			echo $indent." <?switch(\${$label}Item['objectTypeName']){\n";
		}

    if(count($objectTypes) == 0){
        echo $indent." <?=latticeview::Factory(\${$label}Item)->view()->render();?>\n";
    }

      $i=0;
		foreach ($objectTypes as $objectTypeName) {
         if ($doSwitch) {
            echo $indent;
            if($i==0)
               echo "    case '$objectTypeName':?>\n";
            else 
               echo " <? case '$objectTypeName':?>\n";
         }
         echo $indent . "  <li class=\"$objectTypeName\">\n";
         echo $indent . "   " . "<h2><?=\${$label}Item['title'];?></h2>\n\n";
         foreach (lattice::config('objects', sprintf('//objectType[@name="%s"]/elements/*', $objectTypeName)) as $element) {
           switch($element->tagName){
           case 'list':
             $this->makeListDataHtml($element, "\${$label}Item", $indent);
             break;
           case 'associator':
             $this->makeAssociatorDataHtml($element, "\${$label}Item", $indent);
             break;
           default:
             frontend::makeHtmlElement($element, "\${$label}Item", $indent . "   ");
             break;
           }
         }

         //handle lower levels
         if ($frontendNode) {
            foreach (lattice::config('frontend', 'includeData', $frontendNode) as $nextLevel) {
               $this->makeIncludeDataHtml($nextLevel, "\${$label}Item", $objectTypeName, $indent . "   ");
            }
         }

         echo $indent . "  </li>\n";
         if ($doSwitch) {
            echo $indent . " <?  break;?>\n";
         }
         $i++;
      }
      if ($doSwitch) {
         echo $indent . "<? }?>\n";
      }


      echo $indent . "<?endforeach;?>\n" .
      $indent . "</ul>\n\n";
   }

   protected function getChildrenObjectTypes($object){
      $objectTypes = array();
	   if ($object->loaded()) {
         //find its addable objects
         foreach (lattice::config('objects', sprintf('//objectType[@name="%s"]/addableObject', $object->objecttype->objecttypename)) as $addable) {
            $objectTypeName = $addable->getAttribute('objectTypeName');
            $objectTypes[$objectTypeName] = $objectTypeName;
         }
         //and follow up with any existing data
         $children = $object->getPublishedChildren();
         foreach ($children as $child) {
            $objectTypeName = $child->objecttype->objecttypename;
            $objectTypes[$objectTypeName] = $objectTypeName;
         }
      }
      return $objectTypes;
      
   }
}
