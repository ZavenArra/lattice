<?php

Class Initializer_Cms {

	public function initialize() {
		
      
      Graph::configureTemplate(Kohana::config('cms.graphRootNode'));
      Graph::addRootNode(Kohana::config('cms.graphRootNode'));
      
      MOP_Initializer::addMessage('configured graph root node');
      

	}


}
