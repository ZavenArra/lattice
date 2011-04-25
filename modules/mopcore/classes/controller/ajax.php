<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ajax extends Controller_MOP {

	public function action_index()
	{
		throw new HTTP_Exception_404('Ajax controller called without action. Check URL.');
	}

	/*
	public function action_handleRequest($uri){
		$subRequest = Request::Factory($uri);
		$data = $subRequest->execute()->data();
		$ajaxResponse = array(
			'returnValue' => TRUE,
			'response'=>$data
		);
		$this->response->body(json_encode($ajaxResponse));
	}
	 */

	public function action_data($uri)
	{
		//request to child, just data

		try {
			$subRequest = Request::Factory($uri);
			$data = $subRequest->execute()->data();
		} catch (Exception $e) {
			//return HTML from exception
                        $message = $e->getMessage() . $e->getTrace();
			$ajaxResponse = array(
				'returnValue' => FALSE,
                                'response' => $message
                                
			);
												$this->response->body(json_encode($subRequest->execute()->data()));
 //                       throw $e;
			return;
		}
		$ajaxResponse = array(
			'returnValue' => TRUE,
			'response'=>$data
		);
		$this->response->body(json_encode($ajaxResponse));
	}

	public function action_html($subRequestUri)
	{
		//request to child, just html and js html
		$subRequest = Request::Factory($subRequestUri);
		$html = $subRequest->execute()->body();

		$cssResources = array();
		foreach($this->resources['librarycss'] as $css){
			$cssResources[] =	HTML::style($css);
		}
		foreach($this->resources['css'] as $css){
			$cssResources[] = 	HTML::style($css);
		}

		$jsResources = array();
		foreach($this->resources['libraryjs'] as $js){
			$jsResources[] = HTML::script($js);		
		}
		foreach($this->resources['js'] as $js){
			$jsResources[] =  HTML::script($js);		
		}


		$ajaxResponse = array(
			'response'=>array(
					'html'=>$html,
					'js'=>$jsResources,
					'css'=>$cssResources
				)
		);
		$this->response->body(json_encode($ajaxResponse));
	}

	public function action_compound()
	{
		//request to child, just data
		$this->response->body('This should return a compound data object - html and data');
	}

} // End Welcome
