<?
class RouteVirtualModulesHook{
	public static function RouteVirtualModules(){

		if(Router::$controller){
			return;
		}

		Kohana::log('info', 'Attempting Virtual Module Routing');

		$virtualModule = Router::$rsegments[0];

		//what we'll try doing is to look up the class in cms.php and create the module
		$config = Kohana::config('cms.templates');
		$modules = array();
		foreach($config as $template){
			foreach($template as $block){
				if($block['type']=='module'){ 
					//there could be other type of virtual modules
					//this is a total hack
					$modules[$block['modulename']] = $block;
				} else if ($block['type']=='list'){
					$modules[$block['class']] = $block;
					$modules[$block['class']]['controllertype'] = 'list';
				}
			}
		}

		if(in_array($virtualModule, array_keys($modules) )){
			$module = $modules[$virtualModule];
			$includeclass = 'class '.$virtualModule.'_Controller extends '.$module['controllertype'].'_Controller { } ';
			eval($includeclass);

			Router::$controller = $virtualModule;
			Router::$controller_path = 'modules/mop/controllers/virtual.php';
			Router::$method = Router::$rsegments[1];
			$segments = array_slice(Router::$rsegments, 2);
			Router::$arguments = $segments;
			Kohana::log('info', 'Routed Virtual Module');

		}

	}

}

//add this event at the end of the routing chain


