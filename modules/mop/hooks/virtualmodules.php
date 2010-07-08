<?
class RouteVirtualModulesHook{
	public static function RouteVirtualModules(){

		if(Router::$controller){
			return;
		}

		Kohana::log('info', 'Attempting Virtual Module Routing');

		$module = Router::$rsegments[0];

		//what we'll try doing is to look up the class in cms.php and create the module
		$config = Kohana::config('cms.modules');
		$modules = array();
		foreach($config as $template){
			foreach($template as $block){
				if($block['type']=='module'){
					$modules[$block['modulename']] = $block;
				}
			}
		}
		if(in_array($module, array_keys($modules) )){
			$module = $modules[$module];
			$includeclass = 'class '.$module['modulename'].'_Controller extends '.$module['controllertype'].'_Controller { } ';
			eval($includeclass);

			Router::$controller = $module['modulename'];
			Router::$controller_path = 'modules/mop/controllers/virtual.php';
			Router::$method = Router::$rsegments[1];
			$segments = array_slice(Router::$rsegments, 2);
			Router::$arguments = $segments;
			Kohana::log('info', 'Routed Virtual Module');

		}

	}

}

//add this event at the end of the routing chain


