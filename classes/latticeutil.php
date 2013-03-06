<?php

/*
 * Class: latticeutil
 * Utility helper class
 */
/* @package Lattice */
Class latticeutil {

	/*
	 * Function: get_micro_seconds()
	 * Returns a microseconds of current time as a 3 place float
	 * Returns: Microseconds
	 */
	public static function get_micro_seconds(){
		list($usec, $sec) = explode(" ", microtime());
		return number_format((float)$usec, 3);
	}

	/*
	 * Function get_micro_timestamp()
	 * Creates a timestamp including microseconds
	 * Returns: Microsecond timestamp
	 */
	public static function get_micro_timestamp(){
		$timestamp = date('Ymd_his') . substr(latticeutil::get_micro_seconds(), 1) ;
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
	public static function img($file, $prefix, $alt,  $extra = null){
		if(!$file->$prefix->fullpath 
			OR !file_exists($file->$prefix->fullpath)){
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
	 * Function: check_role_access($role)
	 * Checks whether the currently logged in user has a certain role
	 * Parameters: 
	 * $role - the role to check against
	 * Returns: true or false
	 */
	public static function check_role_access($role){

    if(class_exists('Auth')){ //If auth module not installed, grant access
      if($role AND !Auth::instance()->logged_in($role)){
        return false;
      } else {
        return true;
      }
    } else {
      return true;
    }
	}
   
   /*
    * Check for role access when an array of roles have access
    */
   public static function check_access($roles){
      if(!$roles){
         return true;
      }
      if(!is_array($roles)){
         $roles = array($roles);
      }
      foreach($roles as $role){
         if(latticeutil::check_role_access($role)){
            return true;
         }
      }
      return false;
      
   }

	/*
	 * Function: decode_recurse($value)
	 */
	private static function decode_recurse($value){
		//handle object?
		if(!is_array($value)){
			return html_entity_decode($value);
		} else {
			for($i=0, $keys=array_keys($value), $count=count($value); $i<$count; $i++){
				$value[$keys[$i]] = latticeutil::decode_recurse($value[$keys[$i]]);
			}
			return $value;
		}
	}

	public static $modulos;
	public static $modulos_options_count;
	public static function modulo($identifier, $options){
		self::$modulos_options_count = count( $options );
		if(!is_array(self::$modulos)){
			self::$modulos = array();
		}
		if(!isset(self::$modulos[$identifier])){
			self::$modulos[$identifier] = 0;
		}
		$index = self::$modulos[$identifier];
		self::$modulos[$identifier]++;
		return $options[$index%self::$modulos_options_count];

	}


	/**
	 * Formats a line (passed as a fields  array) as CSV and returns the CSV as a string.
	 * Adapted from http://us3.php.net/manual/en/function.fputcsv.php#87120
	 */
	public static function array_to_csv( array &$fields, $delimiter = ';', $enclosure = '"', $enclose_all = false, $null_to_mysql_null = false ) {
		$delimiter_esc = preg_quote($delimiter, '/');
		$enclosure_esc = preg_quote($enclosure, '/');

		$output = array();
		foreach ( $fields as $field ) {
			if ($field === null AND $null_to_mysql_null) {
				$output[] = 'NULL';
				continue;
			}

			// Enclose fields containing $delimiter, $enclosure or whitespace
			if ( $enclose_all OR preg_match( "/(?:${delimiter_esc}|${enclosure_esc}|\s)/", $field ) ) {
				$output[] = $enclosure . str_replace($enclosure, $enclosure . $enclosure, $field) . $enclosure;
			}
			else {
				$output[] = $field;
			}
		}

		return implode( $delimiter, $output );
	}

}
