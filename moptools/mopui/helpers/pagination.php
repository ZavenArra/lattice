<?

Class pagination extends pagination_base {

	public function controls($identifier, $marshal, $totalPages ){
		return parent::controls($identifier, $marshal, $totalPages, 'paginationControl');
	}
}
