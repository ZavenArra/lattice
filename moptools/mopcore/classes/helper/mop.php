<?

Class Helper_Mop {

	public static $webRoot = null;

	public static function convertFullPathToWebPath($fullPath){


		if(self::$webRoot == null){
			self::$webRoot  = getcwd().'/';
		}
		$webpath = str_replace(self::$webRoot, '', $fullPath);
		
		return $webpath;
	}
}
