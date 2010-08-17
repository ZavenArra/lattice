<?php defined('SYSPATH') or die('No direct script access.');

/*
 * Class: MOP_Controller_Core
 * 
 */

class MOP_Controller_Core extends Controller_Core {

	/*
	 * Variable: config
	 * The configurations for this module
	 */
	public $config;

	/*
	 * Variable: modules
	 * list of submodules to build
	 */
	public $modules = array();

	/*
	 * Variable: controllername
	 * The name of the controller
	 */
	public $controllername;

	/*
	 * Variable: basetemplate
	 * Name of the template to use
	 */
	public $basetemplate = 'default';

	/*
	 * Variable: template
	 * the main view itself
	 */
	public $template;

	/*
	 * Variable: resources
	 * currently resources are stored in views, instead they should be loaded by controller
	 */
	public $resources = array('js'=>array(), 'css'=>array());

	/*
	 * Variable: responseFormat
	 * HTTP or AJAX, determines whether a full webpage will be returned (HTTP) or json (AJAX)
	 */
	protected $responseFormat = 'HTTP';

	/*
	 * Variable: responseType
	 * Determines what will be returned.  HTML - html, DATA - json data from the methodnameData function
	 * or COMBINED - json array containing both data and html
	 */
	protected $responseType = 'HTML';

	/*
	 * Variable: httpPaginationCurrentPage
	 * Global tracker for current page of any pagination call, for use with semi-automatic pagination interface
	 */
	public static $httpPaginationCurrentPage = 1;

	/*
	 * Variable: httpPaginationCurrentList
	 * Defines which list is being paginated, for use with semi-automatic pagination interface
	 */
	public static $httpPaginationCurrentList = Null;

	/*
	 * Function: __construct()
	 * Sets controllername and checks access as matched against config file's authrole for controller
	 * Parameters: none
	 * Returns: nothing
	 */
	public function __construct(){
		parent::__construct();

		$this->controllername = substr(get_class($this), 0, -11);

		$this->checkAccess();

	}

	/*
	 * Function: checkAccess()
	 * Default function for acccess checking for a controller.  Can be overridden in child classes
	 * Checks logged in user against authrole array in config file for controller
	 * Parameters:nothing, except config file
	 * Returns: nothing
	 */
	public function checkAccess(){
		//Authentication check
		$role = Kohana::config(strtolower($this->controllername).'.authrole', FALSE, FALSE);

		//checked if logged in
		if($role && !Auth::instance()->logged_in()){
			$uri = Router::$current_uri;
			$uri = explode('/', $uri);
			if($uri[count($uri)-1] == 'html'){
				unset($uri[count($uri)-1]);
			}
			$redirect = implode('/', $uri);

			url::redirect('auth/login/'.$redirect);
			exit;
		}

		if(is_array($role)){
			$accessGranted = false;
			foreach($role as $aRole){
				if($role=='admin'){
					if(Kohana::config('mop.staging_enabled') && !Kohana::config('mop.staging')){
						$redirect = 'staging/'. Router::$current_uri;
						url::redirect($redirect);
					}
				}

				if(moputil::checkRoleAccess($aRole)){
					$accessGranted = true;
				}
			}
		} else {
			if($role=='admin'){
				if(Kohana::config('mop.staging_enabled') && !Kohana::config('mop.staging')){
					$redirect = 'staging/'. Router::$current_uri;
					url::redirect($redirect);
				}
			}

			$accessGranted = moputil::checkRoleAccess($role);
		}

		if(!$accessGranted){
			$redirect = 'accessdenied';
			url::redirect($redirect);
			exit;
		}

	}

	/*
	 * Function: render()
	 * Build the view for this page
	 * Parameters: none
	 * Returns: nothing
	 */
	protected function render(){

		//and load resources for its possible parents
		$parentclass = get_parent_class($this);
		$parentname = str_replace('_Controller', '', $parentclass);
		Kohana::log('debug', 'Loading Resources for parent');
		$this->template->loadResources(strtolower($parentname));
		//load css and js for the page
		Kohana::log('debug', 'Loading Resources for template name');
		$this->template->loadResources();
		if($this->template->name != strtolower($this->controllername)){
			Kohana::log('debug', 'Loading Library Resources for controller');
			$this->template->loadLibraryResources(strtolower($this->controllername));
		}
		return $this->template->render();
	}

	/*
	 * Function: toWebpage([$customDisplayController = null])
	 * Outputs a complete webpage for the main object, wrapped with configured layout and submodules
	 * Parameters:
	 * $cusomterDisplayController - optionally specify a display controller other than that configured in the
	 * displayView for this page
	 * Returns: nothing, outputs the page to the browser
	 */
	protected function toWebpage($customDisplayController=null){

		//build all the submodes for this page
		$this->buildModules();


		//we are outputting as a full Web Page, so get the Web display controller type
		$defaultcontroller = 'DisplayPublic_Controller';
		if($customDisplayController != null){
			$displaycontroller = $customDisplayController . '_Controller';
		} else if($displaycontroller = Kohana::config(strtolower($this->controllername).'.displaycontroller', FALSE, FALSE)){
			$displaycontroller .= '_Controller';
		} else {
			$displaycontroller = $defaultcontroller;
		}
		$displaycontroller = new $displaycontroller();
		$displaycontroller->buildModules();

		/*
		* build the view for this page
		*/
		//this stuff should happen when the template renders..
		//load resources for it's possible parents
		$parentclass = get_parent_class($this);
		$parentname = str_replace('_Controller', '', $parentclass);
		$this->template->loadResources(strtolower($parentname));
		//load css and js for the page
		$this->template->loadResources();
		if($this->template->name != strtolower($this->controllername)){
			$this->template->loadLibraryResources(strtolower($this->controllername));
		}

		//output the page
		$displaycontroller->outputPage($this->template);
	}

	/*
	  Function:  html()
		Handles request and return as an html request
		Parameters: none
		Returns: is class variable template is subclass of View_Core outputs by calling toWebpage()
	 */
	public function html(){
		Kohana::log('info', "HTML Response");
		$this->responseFormat = 'HTML';

		$arguments = func_get_args();
		if(count($arguments)==0){
		//	echo 'ERROR, NO FUNCTION... FIX THIS STATEMENT';
			$function = 'index';
		} else {
			$function = $arguments[0];
		}
		array_shift($arguments);

		//no access to hidden functions
		if($function[0]=='_'){
			Event::run('system.404');
		}

		$content = call_user_func_array(array($this,$function), $arguments);
		if(is_object($content) && is_subclass_of($content, 'View_Core')){
			$this->template = $content;
		}

		//If there is a template view set, output as a web page
		if(is_object($this->template) && is_subclass_of($this->template, 'View_Core')){
			$this->toWebpage();
		}
	}



	/*
	  Function:  ajax()
		Handles request and return as an ajax request, as per index.php/ajax/method
		Parameters: none
		Returns: nothing, echos json encoding of generated content
	 */
	public function ajax(){
		$this->responseFormat = 'AJAX';

		$arguments = func_get_args();
		if(count($arguments)==0){
			echo 'ERROR, NO FUNCTION... FIX THIS STATEMENT';
		}
		$function = $arguments[0];

		//no access to hidden functions
		if($function[0]=='_'){
			Event::run('system.404');
		}

		array_shift($arguments);
		$content = call_user_func_array(array($this,$function), $arguments);

		//if a view object is returned, render it now
		if(is_object($content) && is_subclass_of($content, 'View_Core')){
			$content = $content->render();
		}

		if(is_array($content)){
			$return = json_encode($content);
		} else {
			$return = json_encode(array('response'=>$content));
		}
		//	Kohana::log('info', $return);
		echo $return;
	}

	/*
	  Function:  queryString()
		Handles request from flash and return as a query string
		Parameters: none
		Returns: nothing, echos query string encoding of generated content
	 */
	public function queryString(){
		$arguments = func_get_args();
		$function = $arguments[0];

		//no access to hidden functions
		if($function[0]=='_'){
			Event::run('system.404');
		}

		array_shift($arguments);
		$content = call_user_func_array(array($this,$function), $arguments);

		if(is_array($content)){
			foreach($content as $name => $value){
				echo '&'.$name.'='.$value;
			}
		} else {
			echo '&returnval='.$content;
		}
	}


	/*
	  Function:  data()
		Wrapper Handles data response type, instead of calling the method specifid in the URL, as
		index.php/ajax/data/method calls methodData function, allowing just data for a view to be 
		returned and updated on the browser side via ajax
		Parameters: none, other than URL
		Returns: echos json encoded data to the browser
	 */
	public function data(){
		Kohana::log('info', 'Response Type: DATA');
		$this->responseType = 'DATA';

		$arguments = func_get_args();
		if(count($arguments)==0){
			throw new Kohana_User_Exception('No Function Specified', 'No function specified to data wrapper');
			echo 'ERROR, NO FUNCTION... FIX THIS STATEMENT';
		}
		$function = $arguments[0].'Data';

		//no access to hidden functions
		if($function[0]=='_'){
			Event::run('system.404');
		}

		array_shift($arguments);
		$return = call_user_func_array(array($this,$function), $arguments);

		//	Kohana::log('info', $return);
		return $return;
	}


	/*
	  Function:  compound()
		Wrapper handles compound response type.  Instead of only calling method specifed in the URL, as
		index.php/ajax/compound/method, calls method and also methodData, combining their results in an 
		json response to ajax browser side.
		Parameters: none, other than URL
		Returns: array('response'=>array('html'=>{html}, 'data'=>{data}))
	 */
	public function compound(){
		Kohana::log('info', 'Response Type: COMPOUND');
		$this->responseType = 'COMPOUND';

		$arguments = func_get_args();
		if(count($arguments)==0){
			echo 'ERROR, NO FUNCTION... FIX THIS STATEMENT';
		}

		$function = $arguments[0];
		array_shift($arguments);

		//no access to hidden functions
		if($function[0]=='_'){
			Event::run('system.404');
		}

		$html = call_user_func_array(array($this,$function), $arguments);
		//if a view object is returned, render it now
		if(is_object($html) && is_subclass_of($html, 'View_Core')){
			$html = $html->render();
		}

		$data = call_user_func_array(array($this,$function.'Data'), $arguments);

		$return = array(
			'response'=>array(
				'html'=>$html,
				'data'=>$data
			)
		);
		//	Kohana::log('info', $return);
		return $return;
	}


	/*
	 * Function: index()
	 * Default function, calls createIndexView which should be implemented to subclass to build index view
	*/
	public function index(){
		//build the default vieew
		call_user_func_array(array($this, 'createIndexView'), array());
	}

	/*
	 * Function: createIndexView()
	 * Often overridden in subclass.  This implementation uses the default template or the controllername
	 * to build a default view
	 */
	public function createIndexView(){
		if(isset($this->defaulttemplate)){
			$this->template = new View(strtolower($this->defaulttemplate));
		} else {
			$this->template = new View(strtolower($this->controllername));
		}
	}


	/*
	 * Function: buildModules
	 * Build all sub-modules and set variable in template
	 * Also in Display_Controller, this should be fixed on a rewrite
	 */
	public function buildModules(){
		//for now $this->modules is set in the class file
		foreach($this->modules as $templatevar => $module){
			$this->buildModule(array('modulename'=>$module), $templatevar);
		}
	}

	/*
	 * Function: buildModule
		This is the same function as in Display_Controller..
		Obviously these classes should share a parent class
	*/
	public function buildModule($module, $templatevar=NULL, $arguments=NULL){
		Kohana::log('debug', 'Loading module: ' . $module['modulename']);
	//	if((Kohana::find_file('controllers', $module['modulename'])) !== FALSE){
			Kohana::log('debug', 'Loading controller: ' . $module['modulename']);

			if(!Kohana::find_file('controllers', $module['modulename'] ) ){
				$includeclass = 'class '.$module['modulename'].'_Controller extends '.$module['controllertype'].'_Controller { } ';
				eval($includeclass);
			}

			$fullname = $module['modulename'].'_Controller';
			$module = new $fullname($arguments);

			//create Main View is a suspect function..
			//why doesn't this just happen in the controllers constructor
			$module->createIndexView();
			$module->template->loadResources();
			//and load resources for it's possible parents
			$parentclass = get_parent_class($module);
			$parentname = str_replace('_Controller', '', $parentclass);
			$module->template->loadResources(strtolower($parentname));

			//build submodules of this module (if any)
			$module->buildModules();

			//render some html
			if($templatevar==NULL){
				$this->template->$module['modulename'] = $module->template->render();
			} else {
				$this->template->$templatevar = $module->template->render();
			}
	}

	/*
	 * Function: pagination
	 * Hook for pagination helper to call for whatever module it appears in, by default assumes
	 * that we are paginating list items, but can be overridden to paginate whatever you want
	 * Parameters:
	 * identifier - the text id of the <ul> we are paginating within, and also the instance of the listmodule
	 * we are paginating, or the identifier for whatever we are paging
	 * pagenum - page number to load
	 */
	public function pagination($identifier, $pagenum=1){
		//these could possible by class vars
		MOP_Controller_Core::$httpPaginationCurrentPage = $pagenum;
		MOP_Controller_Core::$httpPaginationCurrentList = $identifier;
		switch($this->responseFormat){
		case 'HTTP':
			return $this->paginationHTTP($identifier);
			//$this->index();
			break;
		case 'AJAX':
			return $this->paginationAJAX($identifier);
			break;
		}
	}

	/*
	 * Function: paginationHTTP()
	 * Default implementation of pagination interface for HTTP, simply calls index() which should handle paging
	 * Parameters: none
	 * Returns: nothing
	 */
	public function paginationHTTP($identifier){
		$this->index();
	}

	/*
	 * Function: paginationAJAX()
	 * Implementation of pagination interface for AJAX, no default behaviour currently implemented
	 * Parameters: none
	 * Returns: nothing
	 */
	public function paginationAJAX(){
		throw new Kohana_User_Exception('Funtion not implemented', 'Default AJAX pagination not implemented yet');
	}


	/*
	 * Function: buildPaginatedListContent($model, $listIdentifier)
	 * Wondering if this should be a basic option of all models, pagination that is
	 * Any model should be able to be paginated
	 * $model->getPaginatedObjects($itemsPerPage, $currentPage);
	 */
	protected function buildPaginatedListContent($model, $listIdentifier){
		$itemsPerPage = 0;
		if(Kohana::find_file('config', strtolower($this->controllername))){
			$itemsPerPage = Kohana::config(strtolower($this->controllername).'.pagination.'.$listIdentifier.'.itemsPerPage');
		}
		if(!$itemsPerPage){
			$itemsPerPage = 5; //this is the default and should be added to config
		}

		$data = array();

		//find totals
		$model2 = clone $model;
		if(is_subclass_of($model, 'ORM_Core')){
			$all = $model2->find_all();
			$totalRecords = count($all);
			$data['totalRecords'] = $totalRecords;
		} else if(is_subclass_of($model, 'Database_Core')){
//hanging here basicallayy.
			$model2->emptySelect();
			$totalRecords = $model2->count_records();
			$data['totalRecords'] = $totalRecords;
		} else {
			//throw exception
		}
		$data['totalPages'] =  ceil($totalRecords / $itemsPerPage);


		//loop pages
		if($data['totalPages']){
			MOP_Controller_Core::$httpPaginationCurrentPage =  (( MOP_Controller_Core::$httpPaginationCurrentPage - 1) % ($data['totalPages'] )) + 1 ;
		}
		if(MOP_Controller_Core::$httpPaginationCurrentPage <= 0){
			MOP_Controller_Core::$httpPaginationCurrentPage += $data['totalPages'];
		}

		//find data for this page
		$items = $this->getLimitedData($model, $listIdentifier);
		$data['items'] = $items;

		return $data;

	}

	/*
	 * Function: getLimitedData($model, $listIdentifier)
	 * This needs to be integrated into base ORM and Database model class
	 * function that just returns objects for this page
	 */
	protected function getLimitedData($model, $listIdentifier){

		$itemsPerPage = 0;
		if(Kohana::find_file('config', strtolower($this->controllername))){
			$itemsPerPage = Kohana::config(strtolower($this->controllername).'.pagination.'.$listIdentifier.'.itemsPerPage');
		}
		if(!$itemsPerPage){
			$itemsPerPage = 5; //this is the default and should be added to config
		}

		//find current page
		if($listIdentifier == MOP_Controller_Core::$httpPaginationCurrentList){
			$pagenum = MOP_Controller_Core::$httpPaginationCurrentPage;
		} else {
			$pagenum = 1;
		}
		$model->limit($itemsPerPage, ($pagenum-1)*$itemsPerPage );
		if(is_subclass_of($model, 'ORM_Core')){
			$list = $model->find_all();
		} else if(is_subclass_of($model, 'Database_Core')){
			$list = $model->get();
		} else {
			//throw exception
		}
		return $list;

	}

	/*
	 * Function __call($method, $arg)
	 * Should go to 404 or homepage
	 */
	public function __call($method, $arg){
		Event::run('system.404');
	}

	/*
	 * Function: toHTML()
	 * Deprecated rapper to toWebpage()
	 *
	 */
	protected function toHTML(){
		$this->toWebpage();
	}



} // End Controller
