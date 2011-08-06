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

		mop::config('objects', '//objectTypes');
		
		flush();
		
	//	foreach(mop::config('frontend', '//view') as $view ){
		//	//this has removed the ability to build virtual views
		foreach(ORM::Factory('objecttype')->find_all() as $objectType){

			$view = mop::config('frontend', '//view[@name="'.$objectType->objecttypename.'"]');
			if(count($view)){
				$view = $view->item(0);
			} else {
				$vuew = null;
			}
			ob_start();
			if($view){
				$viewName = $view->getAttribute('name');
			} else {
				$viewName = $objectType->objecttypename;
			}
			touch($this->basePath.$viewName.'.php');

			if(!$view ||  ($view && $view->getAttribute('loadPage')=='true')){
				echo "<h1><?=\$content['main']['title'];?></h1>\n\n";
				//this also implies that name is a objecttypename
				foreach(mop::config('objects', 
					sprintf('//objectType[@name="%s"]/elements/*', $viewName )) as $element){
						frontend::makeHtmlElement($element, "\$content['main']");
					}
			}

			if($view && $view->getAttribute('loadPage')=='true'){

				//Now the includeData
				if($iDataNodes = mop::config('frontend',"//view[@name=\"".$view->getAttribute('name')."\"]/includeData")){
					foreach($iDataNodes as $iDataConfig){
						$prefix = "\$content";
						$this->makeIncludeDataHtml($iDataConfig, $prefix, null);
					}
				}

				if($subviews = mop::config('frontend',"//view[@name=\"".$view->getAttribute('name')."\"]/subview")){
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
		}



		echo "Done\n";
	}

	public function makeIncludeDataHtml($iDataConfig, $prefix, $parentTemplate, $indent=''){
		$label = $iDataConfig->getAttribute('label');

		$objectTypes = array();
		//if slug defined, get objectType from slug
		if($slug = $iDataConfig->getAttribute('slug')){
			$object = Graph::object($slug);
			if(!$object->loaded){
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
				foreach(mop::config('objects', sprintf('//objectType[@name="%s"]/addableObject', $parentTemplate)) as $addable){
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
			} else {
				//see if from is a slug
				$object = Graph::object($from);
            if($object->loaded){
					//find its addable objects
					foreach(mop::config('objects', sprintf('//objectType[@name="%s"]/addableObject', $object->objecttype->objecttypename)) as $addable){
						$objectTypeName = $addable->getAttribute('objectTypeName');
						$objectTypes[$objectTypeName] = $objectTypeName;
					}
					//and follow up with any existing data
					$children = $object->getPublishedChildren();
					foreach($children as $child){
						$objectTypeName = $child->objecttype->objecttypename;
						$objectTypes[$objectTypeName] = $objectTypeName;
					}
				}
			}
		}	

		// now $objectTypes contains all the needed objectTypes in the view
		echo $indent."<h2>$label</h2>\n\n";

		$doSwitch = false;
		if(count($objectTypes)>1){
			$doSwitch = true;
		}

		echo $indent."<ul id=\"$label\" >\n";
		echo $indent."<?foreach({$prefix}['$label'] as \${$label}Item):?>\n";
		if($doSwitch){
			echo $indent." <?switch(\${$label}Item['objectTypeName']){?>\n";
		}

		foreach($objectTypes as $objectTypeName){
			if($doSwitch){
				echo $indent."<? case '$objectTypeName':?>\n";
			}
			echo $indent."  <li class=\"$objectTypeName\">\n";
      echo $indent."   "."<h2><?=\${$label}Item['title'];?></h2>\n\n";
			foreach(mop::config('objects', 
				sprintf('//objectType[@name="%s"]/elements/*', $objectTypeName )) as $element){
					frontend::makeHtmlElement($element, "\${$label}Item", $indent."   ");
				}

			//handle lower levels
			foreach(mop::config('frontend', 'includeData', $iDataConfig) as $nextLevel){
				$this->makeIncludeDataHtml($nextLevel, "\${$label}Item", $objectTypeName, $indent."   ");
			}

			echo $indent."  </li>\n";
			if($doSwitch){
				echo $indent."<?  break;?>\n";
			}
		}
		if($doSwitch){
			echo $indent."<? }?>\n";
		}


		echo $indent."<?endforeach;?>\n".
			$indent."</ul>\n\n";


	}

}
