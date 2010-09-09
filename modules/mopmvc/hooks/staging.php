<?
class StagingHook{
	public static function RouteStaging(){

		//check to see if we're trying for staging
		//and if we are, use the database for staging
		//and set Router values
		if(strpos(Router::$current_uri, 'staging')===0){

			Kohana::log('info', Router::$current_uri);
			ORM::setDB('staging');


			Router::$current_uri = substr(Router::$current_uri, 7);
			if(strpos(Router::$current_uri, '/')===0){
				Router::$current_uri = substr(Router::$current_uri, 1);
			}
			//check for access to staging environment
			if(!Auth::instance()->logged_in('staging') && !(strpos(Router::$current_uri, 'auth/')===0) ){
				//this is a hack, since flash is broken and doesn't share cookies correctly
				Kohana::log('info', $_SERVER['HTTP_USER_AGENT']);
				
				$flash=false;
				$force=false;
				if(strpos($_SERVER['HTTP_USER_AGENT'], 'Flash')===True){
					$flash=true;
				}
				if(isset($_GET['force']) && $_GET['force']=='hax0r53ewAre0123'){
					$force = true;
				}
				if(!$flash && !$force){
					url::redirect('staging/auth/login/'.Router::$current_uri);
				}
			}

			Kohana::config_set('config.site_domain', Kohana::config('config.site_domain').'staging/');
			Kohana::config_set('config.site_path', Kohana::config('config.site_path').'staging/');
			Kohana::config_set('core.site_domain', Kohana::config('core.site_domain').'staging/');
			Kohana::config_set('core.site_path', Kohana::config('core.site_path').'staging/');
			Kohana::config_set('mop.staging', true);
			Kohana::log('info', 'routed staging');
		} 

		if(Router::$current_uri == null){
			Router::$current_uri = '';
		}


	}

	private static function badRequest(){
		header("Location: / \n\n");
		exit;
	}
}

