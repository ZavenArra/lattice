<?

/*
 * Class: moputil
 * Utility helper class
 */
Class moputil {

	/*
	 * Function: getMicroSeconds()
	 * Returns a microseconds of current time as a 3 place float
	 * Returns: Microseconds
	 */
	public function getMicroSeconds(){
		list($usec, $sec) = explode(" ", microtime());
		return number_format((float)$usec, 3);
	}

	/*
	 * Function getMicroTimestamp()
	 * Creates a timestamp including microseconds
	 * Returns: Microsecond timestamp
	 */
	public function getMicroTimestamp(){
		$timestamp = date('YmdHis') . substr(moputil::getMicroSeconds(), 1) ;
		Kohana::log('info', 'TIMESTAMP: '.$timestamp);
		return $timestamp;
	}

	/*
	 * Function:  img($file, $prefix, $alt,  $extra = null){
	 * Echos an image tag as built from a mop file object.  
	 * Parameters: 
	 * $file - mop file object
	 * $prefix - the prefix to output
	 * $alt - alt tag phrase
	 * $extra - extra stuff to go inside the tag attributes area
	 * Returns: if file exists, return the img src tag code, otherwise return null
	 */
	public function img($file, $prefix, $alt,  $extra = null){
		if(!$file->$prefix->fullpath 
			|| !file_exists($file->$prefix->fullpath)){
			return null;
		}
		$img = sprintf('<img src="%s" width="%s" height="%s" alt="%s" %s>',
		 	$file->$prefix->fullpath, 
			$file->$prefix->width,
			$file->$prefix->height,
			$alt, 
			$extra);
		return $img;
	}

	/*
	 * Function: checkRoleAccess($role)
	 * Checks whether the currently logged in user has a certain role
	 * Parameters: 
	 * $role - the role to check against
	 * Returns: true or false
	 */
	public function checkRoleAccess($role){

		if($role && !Auth::instance()->logged_in($role)){
			return false;
		} else {
			return true;
		}
	}

	/*
	 * Function: decode_recurse($value)
	 */
	private function decode_recurse($value){
		//handle object?
		if(!is_array($value)){
			return html_entity_decode($value);
		} else {
			for($i=0, $keys=array_keys($value), $count=count($value); $i<$count; $i++){
				$value[$keys[$i]] = moputil::decode_recurse($value[$keys[$i]]);
			}
			return $value;
		}
	}


}
