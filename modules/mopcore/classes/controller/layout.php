<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Layout extends Controller_MOP {

	public function action_htmlLayout($controller, $action=null, $arguments=null)
	{
			$subRequest = Request::Factory($controller.'/'.$action.'/'.$arguments);
			$this->response->body($subRequest->execute()->body());	
			$this->outputLayout();
	}

/*
 * Function: outputLayout
 * Wrap the response in its configured layout
 */
	public function outputLayout(){
		//set layout - read from config file
		$layout = 'LayoutAdmin';	
		$layoutView = View::Factory($layout);

		//get js and css for this layout .. ??? not the way to do this
		
		//build js and css
		$stylesheet = '';
		foreach($this->resources['librarycss'] as $css){
			$stylesheet .=	HTML::style($css)."\n       ";
		}
		foreach($this->resources['css'] as $css){
			$stylesheet .=	HTML::style($css)."\n       ";
		}
		$layoutView->stylesheet = $stylesheet;

		$javascript = '';
		foreach($this->resources['libraryjs'] as $js){
			$javascript .= HTML::script($js)."\n        ";		
		}
		foreach($this->resources['js'] as $js){
			$javascript .= HTML::script($js)."\n        ";		
		}
		$layoutView->javascript = $javascript;

		$layoutView->body = $this->response->body();
		$this->response->body($layoutView->render());
	}


} // End Welcome
