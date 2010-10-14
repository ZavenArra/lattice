<?
set_error_handler(array('Cli', 'error_handler'), E_ALL);

Class Frontend_Controller extends Controller {

	public function __construct(){
		parent::__construct();
	}

	public function index(){
		echo "Configuring Frontend\n";
		echo "Reading application/config/frontend.xml\n";

		mop::config('backend', '//templates');
		
		flush();
		ob_flush();
		
		foreach(mop::config('frontend', '//view') as $view ){
			touch('application/frontend/'.$view->getAttribute('name').'.php');
			chmod('application/frontend/'.$view->getAttribute('name').'.php', 0777);
			echo 'application/frontend/'.$view->getAttribute('name').'.php';
			ob_start();
			if($view->getAttribute('loadPage')=='true'){
				echo "<h1><?=\$content['main']['title'];?></h1>\n\n";
				//this also implies that name is a templatename
				foreach(mop::config('backend', 
					sprintf('//template[@name="%s"]/elements/*', $view->getAttribute('name') )) as $element){
						$this->makeHtmlElement($element, "\$content['main']");
					}
			}


			//Now the includeData
			if($iDataNodes = mop::config('frontend',"//view[@name=\"".$view->getAttribute('name')."\"]/includeData")){
				foreach($iDataNodes as $iDataConfig){
					$prefix = "\$content";
					$this->makeIncludeDataHtml($iDataConfig, $prefix, null);
				}
			}

			if($subviews = mop::config('frontend',"//view[@name=\"".$view->getAttribute('name')."\"]/subView")){
				foreach($subviews as $subviewConfig){
					echo "\n<?=\$".$subviewConfig->getAttribute('label').";?>\n";
				}
			}
			$html = ob_get_contents();
			ob_end_clean();
			$file = fopen('application/frontend/'.$view->getAttribute('name').'.php', 'w');
			fwrite($file, $html);
			fclose($file);
		}



		echo "\n\nDone\n";
	}

	public function makeIncludeDataHtml($iDataConfig, $prefix, $parentTemplate, $indent=''){
		$label = $iDataConfig->getAttribute('label');

		$templates = array();
		//if slug defined, get template from slug
		if($slug = $iDataConfig->getAttribute('slug')){
			$object = ORM::Factory('page', $slug);
			if(!$object->loaded){
				//error out,
				//object must be loaded from data.xml for this type of include conf
			}
			$templates[] = $object->template->templatename;
		}
		if(!count($templates)){
			$templates = $iDataConfig->getAttribute('templateFilter');
			if($templates!='all'){
				$templates = explode(',', $templates);
			} else {
				$templates = array();
			}
		}
		if(!count($templates)){
			//no where for templates
			//assume that we'll have to make a good guess based off 'from' parent
			$from=$iDataConfig->getAttribute('from');
			if($from=="parent"){

				//get the info from addableObjects of the current
				foreach(mop::config('backend', sprintf('//template[@name="%s"]/addableObject', $parentTemplate)) as $addable){
					$templateName = $addable->getAttribute('templateName');
					$templates[$templateName] = $templateName;
				}

				//and we can also check all the existing data to see if it has any other templates
				$parentObjects = ORM::Factory('page')->templateFilter($parentTemplate)->publishedFilter()->find_all();
				foreach($parentObjects as $parent){
					$children = $parent->getPublishedChildren();
					foreach($children as $child){
						$templateName = $child->template->templatename;
						$templates[$templateName] = $templateName;
					}
				}
			} else {
				//see if from is a slug
				$object = ORM::Factory('page', $from);
				if($object->loaded){
					//find its addable objects
					foreach(mop::config('backend', sprintf('//template[@name="%s"]/addableObject', $object->template->templatename)) as $addable){
						$templateName = $addable->getAttribute('templateName');
						$templates[$templateName] = $templateName;
					}
					//and follow up with any existing data
					$children = $object->getPublishedChildren();
					foreach($children as $child){
						$templateName = $child->template->templatename;
						$templates[$templateName] = $templateName;
					}
				}
			}
		}	

		// now $templates contains all the needed templates in the view
		echo $indent."<h2>$label</h2>\n\n";

		$doSwitch = false;
		if(count($templates)>1){
			$doSwitch = true;
		}

		echo $indent."<ul id=\"$label\" >\n";
		echo $indent."<?foreach({$prefix}['$label'] as \${$label}Item):?>\n";
		if($doSwitch){
			echo $indent." <?switch(\${$label}Item['templateName']){\n";
		}

		foreach($templates as $templateName){
			if($doSwitch){
				echo $indent." case '$templateName':?>\n";
			}
			echo $indent."  <li class=\"$templateName\">\n";
			foreach(mop::config('backend', 
				sprintf('//template[@name="%s"]/elements/*', $templateName )) as $element){
					$this->makeHtmlElement($element, "\${$label}Item", $indent."   ");
				}

			//handle lower levels
			foreach(mop::config('frontend', 'includeData', $iDataConfig) as $nextLevel){
				$this->makeIncludeDataHtml($nextLevel, "\${$label}Item", $templateName, $indent."   ");
			}

			echo $indent."  </li>\n";
			if($doSwitch){
				$indent."  break;\n";
			}
		}
		if($doSwitch){
			echo $indent." }\n";
		}


		echo $indent."<?endforeach;?>\n".
			$indent."</ul>\n\n";


	}

	public function makeHtmlElement($element, $prefix, $indent=''){

		$field = $element->getAttribute('field');

		switch($element->nodeName){
		case 'list':
			$family = $element->getAttribute('family');
			$addables = mop::config('backend', 'addableObject', $element);		
			$addable = $addables->item(0);
			$templateName = $addable->getAttribute('templateName');
			$listItemElements = mop::config('backend', sprintf('//template[@name="%s"]/elements/*', $templateName));		
			echo $indent."<ul id=\"$family\" >\n";
			echo $indent."<?foreach({$prefix}['$family'] as \$label => \${$family}ListItem):?>\n";
			echo $indent." <li class=\"$templateName\">\n";
			foreach($listItemElements as $element){
				$this->makeHtmlElement($element, "\${$family}ListItem", $indent.'  ');
			}
			echo $indent." </li>\n";
			echo $indent."<?endforeach;?>\n";
			echo $indent."</ul>\n\n";
			break;

		case 'singleImage':
			if(!($size=$element->getAttribute('size'))){
				$size = 'original';	
			}
			echo $indent."<?if(is_object({$prefix}['$field'])):?>\n";
			echo $indent." <img id=\"$field\" src=\"<?={$prefix}['$field']->{$size}->fullpath;?>\" width=\"<?={$prefix}['$field']->{$size}->width;?>\" height=\"<?={$prefix}['$field']->{$size}->height;?>\" alt=\"<?={$prefix}['$field']->{$size}->filename;?>\" />\n";
			echo $indent."<?endif;?>\n\n";
			break;
		case 'singleFile':
			echo $indent."<?if(is_object({$prefix}['$field'])):?>\n";
			echo $indent."<a href=\"<?={$prefix}['$field']->filename;?>\"><?={$prefix}['$field']->filename;?>\</a>\n\n";
			echo $indent."<?endif;?>\n\n";
			break;
		default:
			echo $indent."<p class=\"$field\"> <?={$prefix}['$field'];?></p>\n\n";
			break;
		}

	}

}
