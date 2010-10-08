<?
set_error_handler(array('Cli', 'error_handler'), E_ALL);

Class Frontend_Controller extends Controller {

	public function __construct(){
		parent::__construct();
	}

	public function index(){
		echo "Configuring Frontend\n";
		echo "Reading application/config/frontend.xml\n";
		
		flush();
		ob_flush();
		
		foreach(mop::config('frontend', '//view') as $view ){
			touch('application/frontend/'.$view->getAttribute('name').'.php');
			ob_start();
			if($view->getAttribute('loadpage')=='true'){
				echo "<h1><?\$content['main']['title'];?></h1>\n\n";
				//this also implies that name is a templatename
				foreach(mop::config('backend', 
					sprintf('//template[@name="%s"]/elements/*', $view->getAttribute('name') )) as $element){
						$this->makeHtmlElement($element, 'main');
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

	public function makeHtmlElement($element, $prefix){

		$field = $element->getAttribute('field');

		switch($element->nodeName){
		case 'singleImage':
			if(!($size=$element->getAttribute('size'))){
				$size = 'original';	
			}
			echo "<img id=\"$field\" src=\"<?=\$content['$prefix']['$field']->{$size}->fullpath;?>\" width=\"<?=\$content['$prefix']['$field']->{$size}->width;?>\" height=\"<?=\$content['$prefix']['$field']->{$size}->height;?>\" alt=\"<?=\$content['$prefix']['$field']->{$size}->filename;?>\" />";
			break;
		case 'singleFile':
			echo "<a href=\"\"></a>";
			break;
		default:
			echo "<p class=\"$field\"> <?=\$content['main']['$field'];?></p>\n";
			break;
		}

	}

}
