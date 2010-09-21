<?
set_error_handler(array('Cli', 'error_handler'), E_ALL);
//set_exception_handler(('Cli::exception_handler'));
require('modules/yaml/lib/sfYaml.php');
require('modules/yaml/lib/sfYamlParser.php');

Class ConfigSite_Controller extends Controller {



	//the final config outputs
	public $config = array(
		'cms'=>array(),
		'cms_dbmap'=>array(),
		'cms_templates'=>array(),
		'cms_images'=>array(),
	);

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
		foreach(mop::config('backend', '//template') as $template){
			foreach(mop::config('backend', '//template[@name="'.$template->getAttribute('name').'"]/elements/*') as $item ){
				$field = $item->getAttribute('field');
				if(!preg_match('/^[A-z0-9]*$/', $field)){
					$errors[] = "Element field names must be alphanumeric.  field=\"$field\" found in template ".$template->getAttribute('name');
				}
			}
		}
		if(count($errors)){
			foreach($errors as $error){
				echo $error."\n";
			}
			die("Did not pass validation \n");
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
				$tRecord->nodetype = strtoupper($template->getAttribute('nodeType'));
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
					$ltRecord->nodetype = 'CONTAINER';
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

		//	var_export($this->config);
		//$this->writeConfig();


    exit;

	}

	public function insertData($parentId = 0, $prefix = '/configuration/data/'){
    echo 'inserting '.$prefix;

		foreach(mop::config('backend', $prefix.'item')  as $item){
      echo 'found contentnode';
			flush();
			ob_flush();
			$object = ORM::Factory('page');
			$template = ORM::Factory('template', $item->getAttribute('templateName'));
      if(!$template->id){
				die("Bad template name ".$item->getAttribute('templateName')."\n");
			}
			$object->template_id = $template->id;
			$object->published = true;
			$object->parentid = $parentId;
			$object->save();
      echo ')))'.$item->getAttribute('templateName');
			foreach(mop::config('backend', sprintf($prefix.'item[@templateName="%s"]/content/*', $item->getAttribute('templateName'))) as $content){
        $field = $content->tagName;
        if($field == 'title'){
          $object->slug = cms::createSlug($content->nodeValue);
        }
				$object->contenttable->$field = $content->nodeValue;
			}
      $object->save();
      $object->contenttable->save();

			//do recursive if it has children
      if(mop::config('backend', $prefix.'item/item')){
        $this->insertData($object->id,  $prefix.'item/');
      }
		}
	}


	public function writeConfig(){
		foreach($this->config as $name =>  $config){
			$name = strtolower($name);
			$fp = fopen('application/modules/cms/config/'.$name.'.php', 'w');
			fwrite($fp, "<?\n\n");
			foreach($config as $key => $params){
				$string = "\$config['$key'] = " . preg_replace("/[0-9]+\s+=>\s+/", '', var_export($params, true ) ).";\n\n";
				fwrite($fp, $string);	
			}
		}
	}	



	public function buildListModuleConfig($item){
		$config['labels'] = array();
		$config['fields'] = array();
		$config['labels'] = array();
		$config['dbmap'] = array();


		if(isset($item['listmoduleparameters']) && is_array($item['listmoduleparameters']['fields'])){
			if(isset($item['listmoduleparameters']['label'])){
			$config['modulelabel'] = $item['listmoduleparameters']['label'];

			} else {
			$config['modulelabel'] = $item['listmoduleparameters']['modulelabel']; //the old way
			}
			$typeindexes = array();
			$typeindexes['field'] = 1;
			$typeindexes['file'] = 1;
			$typeindexes['singleImage'] = 1;
			foreach($item['listmoduleparameters']['fields'] as $fieldconfig ){

				switch($fieldconfig['type']){
				case 'ipe':
				case 'checkbox':
				case 'radioGroup':
					$fieldmapname = 'field';
					break;

				case 'singleImage':
					$fieldmapname = 'file';
					break;
				default:
					$fieldmapname = $fieldconfig['type'];
					break;
				}

				switch($fieldconfig['type']){
				case 'file':
					$config['files']['file']['extensions'] = $this->valueIfSet('extensions', $fieldconfig);
					$config['files']['file']['resize']['imagesizes'] = $this->valueIfSet('sizes', $fieldconfig);
					break;
				case 'singleImage':
					$config['singleimages']['file']['extensions'] = $this->valueIfSet('extensions', $fieldconfig);
					$config['singleimages']['file']['resize']['imagesizes'] = $this->valueIfSet('sizes', $fieldconfig);
					break;
				default:
					$config['fields'][$fieldconfig['field']] = $fieldconfig['type'];
					$config['labels'][$fieldconfig['field']] = $fieldconfig['label'];
					$config['dbmap'][$fieldconfig['field']] = $fieldmapname . $typeindexes[$fieldmapname];
					break;
				}

				$typeindexes[$fieldmapname]++;
			}
		}


		$this->config[$item['modulename']] = $config;	
		

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

	public function toJson($filename){
	   require($filename);
		 $json = json_encode($config);
		 echo $this->jsonReadable($json);
	}

public function jsonReadable($json, $html=FALSE) {
	$tabcount = 0;
	$result = '';
	$inquote = false;
	$ignorenext = false;

	if ($html) {
		$tab = "&nbsp;&nbsp;&nbsp;";
		$newline = "<br/>";
	} else {
		$tab = "\t";
		$newline = "\n";
	}

	for($i = 0; $i < strlen($json); $i++) {
		$char = $json[$i];

		if ($ignorenext) {
			$result .= $char;
			$ignorenext = false;
		} else {
			switch($char) {
			case '{':
				$tabcount++;
				$result .= $char . $newline . str_repeat($tab, $tabcount);
				break;
			case '}':
				$tabcount--;
				$result = trim($result) . $newline . str_repeat($tab, $tabcount) . $char;
				break;
			case ',':
				$result .= $char . $newline . str_repeat($tab, $tabcount);
				break;
			case '"':
				$inquote = !$inquote;
				$result .= $char;
				break;
			case '\\':
				if ($inquote) $ignorenext = true;
				$result .= $char;
				break;
			default:
				$result .= $char;
			}
		}
	}

	return $result;
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
