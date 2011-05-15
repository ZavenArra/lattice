<?

Class ProtocolRoutingHook {

	public function RouteProtocol(){

		Kohana::log('info', 'Protocol Routing: Incoming URI: '.Router::$current_uri);
		$uri = explode('/', Router::$current_uri);

		$controllerIndex=0;

		if(!isset($uri[0]) || !$uri[0]){
			$uri[0] = Kohana::config('routes._default');
		}

		if(isset($uri[1]) && $uri[1]=='ajax'){
			//done
		} else if(isset($uri[0])) {
			$controllerIndex = 0;
			if($uri[0] =='ajax'){
				$controllerIndex++;
				$protocol = 'ajax';

				if(isset($uri[1])){
					if($uri[1]=='data'
						|| $uri[1]=='html'
						|| $uri[1]=='compound'){
						$controllerIndex++;
						$type = $uri[1];
						}
				}

			} else {
				$protocol = 'html';
			}
			$controller = $uri[$controllerIndex];
			for($i=0; $i<$controllerIndex+1; $i++){
				array_shift($uri);
			}
			if(isset($type)){
				array_unshift($uri, $type);
			}
			if(isset($protocol)){
				array_unshift($uri, $protocol);
			}
			array_unshift($uri, $controller);

		}

		//print_r($uri);



		Router::$current_uri = implode('/', $uri);
		Kohana::log('info', 'Protocol Routing: Utilizing URI: '.Router::$current_uri);
	}


}


