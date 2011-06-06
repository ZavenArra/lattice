<?php defined('SYSPATH') or die('No direct script access.');


/*
 * Class: Controller_Layout
 * Extension of Controller_MOP which handles automatic wrapping of the main request in header and footer layout.
 * Extend this class and set $_aactionsThatGetLayout with actions that should always be wraped with the layout specified in their config.
 * In the future, config could have a mapping of actions to layouts, if necessary.
 * Auto wrapping can be manually bypassed by calling the html action as html/controller/action/etc.
 */

class Controller_Layout extends Controller_MOP {
	
	protected $_actionsThatGetLayout = array();
	
	protected $subRequest;
	
	public function after(){
		if($this->request == Request::initial() ){
			if(in_array($this->request->action(), $this->_actionsThatGetLayout)){
				$this->wrapWithLayout();
			} 
		
		}
	}
	
/*
 * Function: outputLayout
 * Wrap the response in its configured layout
 */
	public function wrapWithLayout(){
		//set layout - read from config file
		$layout = Kohana::config($this->request->controller() . '.layout');
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
