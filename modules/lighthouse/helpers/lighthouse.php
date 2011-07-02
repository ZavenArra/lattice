<?

/*
 * Class: lighthouse
 * Controller which implements remote filing of tickets with a configured lighthouseapp account
 */
Class lighthouse {

	/*
	 * Function: newTicket($title, $description, [$options] )
	 * Files a new ticket with lighthouse using the configured account
	 * Parameters:
	 * $title - title for the ticket
	 * $description - body of the ticket
	 * $options - array of options as supported by the lighthouseapp api
	 */
	public function newTicket($title, $description, $options = array()){
	// Assemble the account url
		$url = "http://" . Kohana::config('lighthouse.account') . ".lighthouseapp.com/projects/" . Kohana::config('lighthouse.project_id') . "/tickets.xml";

		// Setup the cURL object
		$curl = curl_init();
		curl_setopt( $curl, CURLOPT_POST, 1);
		curl_setopt( $curl, CURLOPT_URL, $url );
		curl_setopt( $curl, CURLOPT_USERPWD, (Kohana::config('lighthouse.user') . ":" . Kohana::config('lighthouse.password')) );

		// Create the XML to post
		$xml = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>" .
			"<ticket>" .
			"<title>" . $title . "</title>" .
			"<body>" . $description . "</body>";
		foreach($options as $key => $value){
			$xml .= "<$key>$value</$key>";
		}
	  $xml .= "</ticket>";

		// Setup the right headers for content-type etc.
		$header = "X-LighthouseToken: " . Kohana::config('lighthouse.token') . "\r\n";
		$header .= "Content-type: application/xml\r\n";
		$header .= "Content-length: " . strlen( $xml ) . "\r\n\n";  // Important! Two linebreaks.
		$header .= $xml;


		curl_setopt( $curl, CURLOPT_HTTPHEADER, array( $header ) );

		// Execute the request and get the result
		ob_start();
		$result = curl_exec( $curl );
		ob_end_clean();
		curl_close($curl);

	}

	public function getOpenTicketsWithTag($tag, $page = 1, $previousTickets = array())
	{
		// Assemble the account url
		$url = "http://" . Kohana::config('lighthouse.account') . ".lighthouseapp.com/projects/" . Kohana::config('lighthouse.project_id') . "/tickets.xml";

		//add query string to url...
		$url .= "?limit=100&page=" . urlencode($page) . "&q=" . urlencode("state:open tagged:" . $tag);

		// Setup the cURL object
		$curl = curl_init();
		curl_setopt( $curl, CURLOPT_HTTPGET, 1);
		curl_setopt( $curl, CURLOPT_URL, $url );
		curl_setopt( $curl, CURLOPT_USERPWD, (Kohana::config('lighthouse.user') . ":" . Kohana::config('lighthouse.password')) );

		// Setup the right headers for content-type etc.
		$header = "X-LighthouseToken: " . Kohana::config('lighthouse.token') . "\r\n\n";

		curl_setopt( $curl, CURLOPT_HTTPHEADER, array( $header ) );

		// Execute the request and get the result
		ob_start();
		$success = curl_exec($curl);
		$result = lighthouse::xml2array(ob_get_clean());
		curl_close($curl);

		if (isset($result['tickets']))
			return array_merge($previousTickets, lighthouse::getOpenTicketsWithTag($tag, $page + 1, $result['tickets']['ticket']));
		else
			return $previousTickets;
	}

	/**
	 * xml2array() will convert the given XML text to an array in the XML structure.
	 * Link: http://www.bin-co.com/php/scripts/xml2array/
	 * Arguments : $contents - The XML text
	 *                $get_attributes - 1 or 0. If this is 1 the function will get the attributes as well as the tag values - this results in a different array structure in the return value.
	 *                $priority - Can be 'tag' or 'attribute'. This will change the way the resulting array sturcture. For 'tag', the tags are given more importance.
	 * Return: The parsed XML in an array form. Use print_r() to see the resulting array structure.
	 * Examples: $array =  xml2array(file_get_contents('feed.xml'));
	 *              $array =  xml2array(file_get_contents('feed.xml', 1, 'attribute'));
	 */
	public function xml2array($contents, $get_attributes=1, $priority = 'tag')
	{
	    if(!$contents) return array();

	    if(!function_exists('xml_parser_create')) {
	        //print "'xml_parser_create()' function not found!";
	        return array();
	    }

	    //Get the XML parser of PHP - PHP must have this module for the parser to work
	    $parser = xml_parser_create('');
	    xml_parser_set_option($parser, XML_OPTION_TARGET_ENCODING, "UTF-8"); # http://minutillo.com/steve/weblog/2004/6/17/php-xml-and-character-encodings-a-tale-of-sadness-rage-and-data-loss
	    xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0);
	    xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1);
	    xml_parse_into_struct($parser, trim($contents), $xml_values);
	    xml_parser_free($parser);

	    if(!$xml_values) return;//Hmm...

	    //Initializations
	    $xml_array = array();
	    $parents = array();
	    $opened_tags = array();
	    $arr = array();

	    $current = &$xml_array; //Refference

	    //Go through the tags.
	    $repeated_tag_index = array();//Multiple tags with same name will be turned into an array
	    foreach($xml_values as $data) {
	        unset($attributes,$value);//Remove existing values, or there will be trouble

	        //This command will extract these variables into the foreach scope
	        // tag(string), type(string), level(int), attributes(array).
	        extract($data);//We could use the array by itself, but this cooler.

	        $result = array();
	        $attributes_data = array();

	        if(isset($value)) {
	            if($priority == 'tag') $result = $value;
	            else $result['value'] = $value; //Put the value in a assoc array if we are in the 'Attribute' mode
	        }

	        //Set the attributes too.
	        if(isset($attributes) and $get_attributes) {
	            foreach($attributes as $attr => $val) {
	                if($priority == 'tag') $attributes_data[$attr] = $val;
	                else $result['attr'][$attr] = $val; //Set all the attributes in a array called 'attr'
	            }
	        }

	        //See tag status and do the needed.
	        if($type == "open") {//The starting of the tag '<tag>'
	            $parent[$level-1] = &$current;
	            if(!is_array($current) or (!in_array($tag, array_keys($current)))) { //Insert New tag
	                $current[$tag] = $result;
	                if($attributes_data) $current[$tag. '_attr'] = $attributes_data;
	                $repeated_tag_index[$tag.'_'.$level] = 1;

	                $current = &$current[$tag];

	            } else { //There was another element with the same tag name

	                if(isset($current[$tag][0])) {//If there is a 0th element it is already an array
	                    $current[$tag][$repeated_tag_index[$tag.'_'.$level]] = $result;
	                    $repeated_tag_index[$tag.'_'.$level]++;
	                } else {//This section will make the value an array if multiple tags with the same name appear together
	                    $current[$tag] = array($current[$tag],$result);//This will combine the existing item and the new item together to make an array
	                    $repeated_tag_index[$tag.'_'.$level] = 2;

	                    if(isset($current[$tag.'_attr'])) { //The attribute of the last(0th) tag must be moved as well
	                        $current[$tag]['0_attr'] = $current[$tag.'_attr'];
	                        unset($current[$tag.'_attr']);
	                    }

	                }
	                $last_item_index = $repeated_tag_index[$tag.'_'.$level]-1;
	                $current = &$current[$tag][$last_item_index];
	            }

	        } elseif($type == "complete") { //Tags that ends in 1 line '<tag />'
	            //See if the key is already taken.
	            if(!isset($current[$tag])) { //New Key
	                $current[$tag] = $result;
	                $repeated_tag_index[$tag.'_'.$level] = 1;
	                if($priority == 'tag' and $attributes_data) $current[$tag. '_attr'] = $attributes_data;

	            } else { //If taken, put all things inside a list(array)
	                if(isset($current[$tag][0]) and is_array($current[$tag])) {//If it is already an array...

	                    // ...push the new element into that array.
	                    $current[$tag][$repeated_tag_index[$tag.'_'.$level]] = $result;

	                    if($priority == 'tag' and $get_attributes and $attributes_data) {
	                        $current[$tag][$repeated_tag_index[$tag.'_'.$level] . '_attr'] = $attributes_data;
	                    }
	                    $repeated_tag_index[$tag.'_'.$level]++;

	                } else { //If it is not an array...
	                    $current[$tag] = array($current[$tag],$result); //...Make it an array using using the existing value and the new value
	                    $repeated_tag_index[$tag.'_'.$level] = 1;
	                    if($priority == 'tag' and $get_attributes) {
	                        if(isset($current[$tag.'_attr'])) { //The attribute of the last(0th) tag must be moved as well

	                            $current[$tag]['0_attr'] = $current[$tag.'_attr'];
	                            unset($current[$tag.'_attr']);
	                        }

	                        if($attributes_data) {
	                            $current[$tag][$repeated_tag_index[$tag.'_'.$level] . '_attr'] = $attributes_data;
	                        }
	                    }
	                    $repeated_tag_index[$tag.'_'.$level]++; //0 and 1 index is already taken
	                }
	            }

	        } elseif($type == 'close') { //End of tag '</tag>'
	            $current = &$parent[$level-1];
	        }
	    }

	    return($xml_array);
	}
}
