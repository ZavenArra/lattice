<?
class MopReadyHook{
	public static function MopReady(){
		$errors = array();

		if(!is_writable('application/logs/')){
			$errors[] = 'application/logs/ is not writable by the web server.';
		}
		if(!is_writable('application/media/')){
			$errors[] = 'application/media/ is not writable by the web server.';
		}
		if(!is_writable('staging/application/media/')){
			$errors[] = 'staging/application/media/ is not writable by the web server.';
		}

		if(count($errors)){
			foreach($errors as $error){
				print $error;
			}
			exit;
		}

	}

}

//add this event at the end of the routing chain


