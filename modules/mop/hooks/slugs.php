<?
class RouteSlugsHook{
	public static function RouteSlugs(){


		if(Router::$controller){
			return;
		}

		Kohana::log('info', 'Attempting to route slug '.var_export(Router::$rsegments, true) );

		$foundpage = null;
		$i=0;
		$ajaxLoad = false;
		if(isset(Router::$rsegments[1]) 
			&& ( Router::$rsegments[1] == 'ajax' || Router::$rsegments[1] == 'html') ){
			$rseg = array();
			$rseg[] = Router::$rsegments[0];
			foreach(array_slice(Router::$rsegments, 2) as $value){
				$rseg[] = $value;
			}
		}
		for($count = count($rseg); $i<$count; $i++) {
			Kohana::log('info', 'checking rsegment '.$rseg[$i]);
			$checkSlug = $rseg[$i];
			if(is_numeric($checkSlug)){
				$page = ORM::Factory('page')->where('id', $checkSlug);
			} else {
				$page = ORM::Factory('page')->where('slug', $checkSlug);
			}
			$page->where('activity IS NULL');
			$page->where('published', 1);
			if($foundpage){
				$page->where('parentid', $foundpage->id);
			}
			$page->find();
			if(!$page->loaded){
				break;
			}
			Kohana::log('info', 'found page');

			$foundpage = $page;
			$slug = $checkSlug;
		}


		if($foundpage && $foundpage->loaded){
			//figure out what controller we are going to use
			//this might need to go within routing, and create a spoofed path
			//another issue is possible collisions

			if($cpath = Kohana::find_file('controllers', $foundpage->template->templatename) ) {
				$controller = $foundpage->template->templatename;
			} else {
				$controller = 'site';
				$cpath = 'modules/mop/controllers/site.php';
			}


			Kohana::log('info', var_export(array_slice(Router::$rsegments, $i), true));
			Router::$controller = $controller;
			Router::$controller_path = $cpath;

			$arguments = array_slice($rseg, $i); //remove the slug from rsegments
			if(isset($arguments[0]) && $arguments[0]!=$slug){
				//Router::$method = $arguments[0];
				//array_shift($arguments);
				//this means we're calling a method on this slug
				//and need to pass the slug as the first argument to the method
			}
			array_unshift($arguments, $slug);	

			if(Router::$rsegments[1] == 'html'){
				Router::$method = 'page';
			} else if(Router::$rsegments[2] == 'ajax') {
				//if it's an ajax load, put the ajax method back on top
				//$arguments = array_slice($arguments, 1); //remove  ajax from arguments 
				Router::$method = 'ajax';
				array_unshift($arguments, 'page');
				Kohana::log('info', 'Identified as ajax load');
			}


			//print_r($arguments);
			//	exit;
			Router::$arguments = $arguments;
			Kohana::log('info', 'Routed slug '.var_export( Router::$arguments, true) );

		}

	}


}

