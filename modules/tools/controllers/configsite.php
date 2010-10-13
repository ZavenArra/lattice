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
		echo "Do you want to write template settings to this database - this will delete all previous templates ? (Yes/no)";
		flush();
		ob_flush();
		$this->scanf('%s', $response);
		if($response == 'Yes'){
			$this->doTemplateDatabase = true;
		} else {
			$this->doTemplateDatabase = false;
		}
		if($this->doTemplateDatabase == true){
			echo "Truncating templates table \n";
			flush();
			ob_flush();
			$db->query('delete from templates');
			$db->query('delete from objectmaps');
			$db->query('alter table templates AUTO_INCREMENT = 1');
			$db->query('alter table objectmaps AUTO_INCREMENT = 1');
		}


		//build templates
		foreach(mop::config('backend', '//template') as $template){

				$dbmapindexes = array(
				'field'=>0,
				'file'=>0,
				'date'=>0,
				'flag'=>0,
			);

			//find or create template record
			$tRecord = ORM::Factory('template', $template->getAttribute('name') );
			if(!$tRecord->loaded){
        echo "\ncreating for ".$template->getAttribute('name')."\n";
				$tRecord = ORM::Factory('template');
				$tRecord->templatename = $template->getAttribute('name');
				$tRecord->nodeType = 'object';
				$tRecord->save();
			}
      echo 'using '.$tRecord->id."\n";

			//create title field
			$checkMap = ORM::Factory('objectmap')->where('template_id', $tRecord->id)->where('column', 'title')->find();
			if(!$checkMap->loaded){
				$index = 'field';
				$newmap = ORM::Factory('objectmap');
				$newmap->template_id = $tRecord->id;
				$newmap->type = $index;
				echo 'index: '.$index;
				$newmap->index = ++$dbmapindexes[$index];
				$newmap->column = 'title';
				$newmap->save();
			}

			
			foreach(mop::config('backend', '//template[@name="'.$template->getAttribute('name').'"]/elements/*') as $item){
        echo 'found an item '.$template->getAttribute('name').':'.$item->tagName."\n";
				switch($item->tagName){

				case 'list':
					$ltRecord = ORM::Factory('template');
					$ltRecord->templatename = $item->getAttribute('family');
					$ltRecord->nodeType = 'container';
					$ltRecord->save();
					break;

        default:
          echo 'default';

          //base cms elements

          //handle dbmap
          $index = null;
          switch($item->tagName){
          case 'ipe':
          case 'radioGroup':
          case 'pulldown':
          case 'time':
          case 'date':
          case 'multiSelect':
            $index = 'field';
            break;
          case 'singleImage':
          case 'singleFile':
            $index = 'file';
            break;
          case 'checkbox':
            $index = 'flag';
            break;
          default:
            continue(2);
            break;
          }	

					//and right here it'll be 'if doesn't already exist in the array'
					//or we'll check the database and just insert a new/next one
					//and this is where the ALTER statements could come in
					//

					$objectmap = ORM::Factory('objectmap')
						->where('template_id', $tRecord->id)
						->where('column', $item->getAttribute('field'))
						->find();
          echo "\n".$tRecord->id."   ".$item->getAttribute('field')."\n";
					if(!$objectmap->loaded){
						$newmap = ORM::Factory('objectmap');
						$newmap->template_id = $tRecord->id;
						$newmap->type = $index;
            echo 'index: '.$index;
						$newmap->index = ++$dbmapindexes[$index];
						$newmap->column = $item->getAttribute('field');
						$newmap->save();
					}

				}
			}
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
