<?php defined('SYSPATH') or die('No direct script access.');

/*
 * Class: Controller_Layout
 * Extension of Controller_Lattice which handles automatic wrapping of the main request in header and footer layout.
 * Extend this class and set $_aactions_that_get_layout with actions that should always be wraped with the layout specified in their config.
 * In the future, config could have a mapping of actions to layouts, if necessary.
 * Auto wrapping can be manually bypassed by calling the html action as html/controller/action/etc.
 */

class Controller_Layout extends Controller_Lattice {
	
	protected $_actions_that_get_layout = array();
	
	protected $sub_request;
	
	public function after(){
		if ($this->request == Request::initial() ){
			if (in_array($this->request->action(), $this->_actions_that_get_layout)){
				$this->wrap_with_layout();
			} 
		}
	}
	
/*
 * Function: output_layout
 * Wrap the response in its configured layout
 */
  public function wrap_with_layout($layout=NULL){
    if ($layout==NULL){
      //set layout - read from config file
      $layout = Kohana::config(strtolower($this->request->controller()) . '.layout');
      if (!$layout){
        throw new Kohana_Exception("Layout controller subclass :controller configured to layout action :action, but no layout set in configuration",
          array(
            ':controller'=>$this->request->controller(),
            ':action'=>$this->request->action()
          ));

      }
    }
		$layout_view = View::Factory($layout);

    if (is_array(Kohana::config($layout.'.resources') ) ){
      foreach (Kohana::config($layout.'.resources') as $key => $paths){
        foreach ($paths as $path){
          $this->resources[$key][$path] = $path;
        }
      }
    }

    //build js and css
    $stylesheet = '';
    foreach ($this->resources['librarycss'] as $css){
			$stylesheet .=	HTML::style($css)."\n       ";
		}
		foreach ($this->resources['css'] as $css){
			$stylesheet .=	HTML::style($css)."\n       ";
		}
		$layout_view->stylesheet = $stylesheet;

		$javascript = '';
		foreach ($this->resources['libraryjs'] as $js){
			$javascript .= HTML::script($js)."\n        ";		
		}
		foreach ($this->resources['js'] as $js){
			$javascript .= HTML::script($js)."\n        ";		
		}
		$layout_view->javascript = $javascript;

		$layout_view->body = $this->response->body();
		$this->response->body($layout_view->render());
	}


} // End Welcome
