<?

/* Class: CMS helper
 * Contains utility function for CMS
 */

class CMS {


	/*
	 * Variable: createSlug($title, $forPageId)
	 * Creates a unique slug to identify a page
	 * Parameters:
	 * $title - optional title for the slug
	 * $forPageId - optionally indicate the id of the page this slug is for to avoid false positive slug collisions
	 * Returns: The new, unique slug
	 */
	public static function createSlug($title=NULL, $forPageId=NULL){
		//create slug
		if($title!=NULL){
			$removeChars = array(
				"'",
				'"',
				'&',
				'?',
				'/',
				'\\',
				')',
				'(',
			);
			Kohana::log('info', $title);
			$slug = str_replace($removeChars, '', strtolower($title));
			$slug = str_replace(' ', '-', strtolower($slug));
			Kohana::log('info', $slug);
			$checkSlug = ORM::Factory('page')
			->regex('slug', '^'.$slug.'[0-9]*$')
			->orderby("slug");
			if($forPageId != NULL){
				$checkSlug->where('pages.id != '.$forPageId);
			}
			$checkSlug = $checkSlug->find_all();
			if(count($checkSlug)){
			$idents = array();
			foreach($checkSlug as $ident){
				$idents[] = $ident->slug;
			}
			natsort($idents);
			$idents = array_values($idents);
			$maxslug = $idents[count($idents)-1];
			if($maxslug){
				$curindex = substr($maxslug, strlen($slug));
				$newindex = $curindex+1;
				$slug .= $newindex;
			}
			}
			return $slug;
		} else {
			return 'No_Title_'.microtime(); //try something else
		}
	}

}


