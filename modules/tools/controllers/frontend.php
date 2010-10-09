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
			echo 'hey';
			touch('application/frontend/'.$view->getAttribute('name').'.php');
			echo 'application/frontend/'.$view->getAttribute('name').'.php';
			ob_start();
			if($view->getAttribute('loadpage')=='true'){
				echo "<h1><?\$content['main']['title'];?></h1>\n\n";
				//this also implies that name is a templatename
				foreach(mop::config('backend', 
					sprintf('//template[@name="%s"]/elements/*', $view->getAttribute('name') )) as $element){
						$this->makeHtmlElement($element, "\$content['main']");
					}
			}
			if($eDataNodes = mop::config('frontend',"//view[@name=\"".$view->getAttribute('name')."\"]/extendeddata")){
				foreach($eDataNodes as $eDataConfig){
					$label = $eDataConfig->getAttribute('label');
					echo "<p>$label Content</p>";
					echo "<?foreach(\$content['$label'] as \$item):?>\n".
						"<ul>\n".
						"<?foreach(\$item as \$field=>\$value):?>\n".
						"<li><?=\$field;?>: <?=\$value;?></li>\n".
						"<?endforeach;?>\n".
						"</ul>\n".
						"<?endforeach;?>\n\n";
				}
			}
			if($subviews = mop::config('frontend',"//view[@name=\"".$view->getAttribute('name')."\"]/subview")){
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



		echo "Done\n";
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
			echo $indent."</ul>\n\n";
			break;

		case 'singleImage':
			if(!($size=$element->getAttribute('size'))){
				$size = 'original';	
			}
			echo $indent."<img id=\"$field\" src=\"<?={$prefix}['$field']->{$size}->fullpath;?>\" width=\"<?={$prefix}['$field']->{$size}->width;?>\" height=\"<?={$prefix}['$field']->{$size}->height;?>\" alt=\"<?={$prefix}['$field']->{$size}->filename;?>\" />\n\n";
			break;
		case 'singleFile':
			echo $indent."<a href=\"\"></a>\n\n";
			break;
		default:
			echo $indent."<p class=\"$field\"> <?={$prefix}['$field'];?></p>\n\n";
			break;
		}

	}

}
