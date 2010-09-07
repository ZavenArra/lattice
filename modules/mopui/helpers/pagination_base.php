<?

Class pagination_base {

	protected $cssClass = null;

	public function controls($identifier, $controller, $totalPages, $cssClass ){

		//Don't print anything if there isn't more than 1 page
		if($totalPages <= 1){
			return null;
		}

		$view = new View('pagination/paginationControls');
		$view->id = $identifier;
		$view->controller = $controller;
		$view->class = $cssClass;
		$view->loadResources();

		if($identifier == MOP_Controller_Core::$httpPaginationCurrentList){
			$pagenum = MOP_Controller_Core::$httpPaginationCurrentPage;
		} else {
			$pagenum = 1;
		}
		$view->pagenum = $pagenum;


		$view->totalPages = $totalPages;

		return $view->render();
	}
}
