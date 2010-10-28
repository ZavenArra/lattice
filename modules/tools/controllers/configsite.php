<?
set_error_handler(array('Cli', 'error_handler'), E_ALL);
//set_exception_handler(('Cli::exception_handler'));
require('modules/yaml/lib/sfYaml.php');
require('modules/yaml/lib/sfYamlParser.php');

Class ConfigSite_Controller extends Controller {


	//the final config outputs
	public function __construct(){
		parent::__construct();
	}

	public function index(){
		echo "Configuring Site\n";

		//load value from config to force validation
		mop::config('backend', '//configuration');

		$db = Database::instance();
			//validate backend.xml data
		$errors = array();
		$templates = array();
		foreach(mop::config('backend', '//template') as $template){
			$templates[] = $template->getAttribute('name');
			foreach(mop::config('backend', '//template[@name="'.$template->getAttribute('name').'"]/elements/*') as $item ){
				$field = $item->getAttribute('field');
				if(!preg_match('/^[A-z0-9]*$/', $field)){
					$errors[] = "Element field names must be alphanumeric.  field=\"$field\" found in template ".$template->getAttribute('name');
				}
			}
		}

		foreach(mop::config('backend', '//addableObject') as $addable){
      $at = $addable->getAttribute('templateName');
      echo $at;
			if(!in_array($at, $templates)){
				$errors[] = "Addable object $at not defined as template in backend.xml";
			}
		}

		if(count($errors)){
			foreach($errors as $error){
				echo $error."\n";
			}
			die("Did not pass validation \n");
		}

		//do some mop specific validation
		$tNames = array();
		$fNames = array();
		$localFNames = array();
		$components = array();
		foreach(mop::config('backend', '//template') as $template){
			$name = $template->getAttribute('name');
			if(in_array($name, $tNames) || in_array($name, $fNames)){
				die("Duplicate Template Name: $name \n");
			}
			$tNames[] = $name;

			$localFNames = array();
			foreach(mop::config('backend', 'elements/*', $template) as $item){
				$name = null;
				switch($item->tagName){

				case 'list':
					$name = $item->getAttribute('family');	
					break;
				}

				if($name){
					if(in_array($name, $tNames)){
						die("List family name cannot match template name: $name \n");
					}
					if(in_array($name, $localFNames)){
						die("List family cannot be repeated within template: $name \n");
					}
					$localFNames[] = $name;
				}
			}

			$fNames = array_merge($fNames, $localFNames);

			//check for components loops
			$comps = array();
			foreach(mop::config('backend','components/*', $template) as $component){
				$comps[] = $component->getAttribute('templateName');	
			}
			if(in_array($name, $comps)){
				die("Component Loop in $name \n");
			} else {
				$components[$name] = $comps;
			}
		}

		//now check for cycles in $components
		foreach($components as $name => $comps){
			//may need a recursive function
		}


		echo "\nYou are attached to database ".Kohana::config('database.'.Database::instance_name($db).'.connection.database')."\n";
	//	echo "Do you want to write template settings to this database - this will delete all previous templates ? (Yes/no)";
		flush();
		ob_flush();
	//	$this->scanf('%s', $response);
			echo "Truncating templates table \n";
			flush();
			ob_flush();
			$db->query('delete from templates');
			$db->query('delete from objectmaps');
			$db->query('alter table templates AUTO_INCREMENT = 1');
			$db->query('alter table objectmaps AUTO_INCREMENT = 1');


		//build templates
		foreach(mop::config('backend', '//template') as $template){
      cms::configureTemplate($template);

	  }	

    exit;

	}

	private function valueIfSet($key, $array, $default=null){
		if(isset($array[$key])){
			return $array[$key];
		} else if($default) {
			return $default;
		} else {
			return null;
		}
	}


	public function scanf($format, &$a0=NULL, &$a1=NULL, &$a2=NULL, &$a3=NULL,
		&$a4=NULL, &$a5=NULL, &$a6=NULL, &$a7=NULL)
	{
		$num_args = func_num_args();
		if($num_args > 1) {
			$inputs = fscanf(STDIN, $format);
			for($i=0; $i<$num_args-1; $i++) {
				$arg = 'a'.$i;
				$$arg = $inputs[$i];
			}
		}
	}


}
