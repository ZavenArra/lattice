<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ajax extends Controller {

	public function action_index()
	{
		throw new HTTP_Exception_404('Ajax controller called without action. Check URL.');
	}

	public function action_data($subRequestUri)
	{
		//request to child, just data
		$this->response->body('This should return just the data as json'.$subRequestUri);
	}

	public function action_html($subRequestUri)
	{
		//request to child, just html
		$subRequest = Request::Factory($subRequestUri);
		$subResponse = $subRequest->execute();
		$responseContent = $subResponse->body();
		$ajaxResponse = array(
			'response'=>$responseContent
		);
		$this->response->body(serialize($ajaxResponse));
	}

	public function action_compound()
	{
		//request to child, just data
		$this->response->body('This should return a compound data object - html and data');
	}

} // End Welcome
