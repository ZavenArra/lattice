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

		$db = Database::instance();
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
			$tRecord = ORM::Factory('template', $template->getAttribute('templatename') );
			if(!$tRecord->loaded){
				$tRecord = ORM::Factory('template');
				$tRecord->templatename = $template->getAttribute('templatename');
				$tRecord->nodetype = $template->getAttribute('nodetype');
				$tRecord->save();
			}


			foreach(mop::config('backend', '//template[@templatename="'.$template->getAttribute('templatename').'"]/module') as $item){
				echo $item->getAttribute('type');
				switch($item->getAttribute('type')){

				case 'list':
					continue;

					//we should be able to hande this somehow 

					//add a template for the list container
					$entry = array();
					$entry['cssClasses'] = $this->valueIfSet('cssClasses', $item);
					$entry['label'] = $this->valueIfSet('label', $item);
					$this->config['cms']['templates'][$item['class']] = $entry;

					//
					////
					//// FUUCK, this really causes a problem.  we need to ADD??? to the xml
					//   isn't there some other solution?
					////
					//
					$this->config['cms_templates'][$item['class']] = array(
						'templatename'=>$item['class'],
						'type'=>'CONTAINER',
						'addable_objects'=>array(
							array(
								'templateId'=>$item['templateId'],
								'templateAddText'=>$item['templateAddText']
							),
						),
					);

					$tRecord = ORM::Factory('template');
					$tRecord->templatename = $item['class'];
					$tRecord->nodetype = 'CONTAINER';
					$tRecord->save();

					//set up component
					//// FUUCK, this really causes a problem.  we need to ADD??? to the xml
					$this->config['cms']['settings'][$template['templatename']]['components'] = array(
						array(
							'templateId'=>$item['class'],
							'data'=>array(
								'title'=>$item['label']
							)
						)
					);
					break;

				default:
					echo 'default';

					//base cms elements

					//handle dbmap
					$index = null;
					switch($item->getAttribute('type')){
					case 'ipe':
						case 'radioGroup':
							case 'pulldown':
								case 'time':
									case 'date':
										case 'multiSelect':
											$index = 'field';
											break;
										case 'singleImage':
											case 'singlefile':
												$index = 'file';
												break;
											case 'checkbox':
												$index = 'flag';
												break;
											default:
												$index = $item->getAttriute('type');
												break;
					}	
				echo $index;

					//and right here it'll be 'if doesn't already exist in the array'
					//or we'll check the database and just insert a new/next one
					//and this is where the ALTER statements could come in
					//

					$objectmap = ORM::Factory('objectmap')
						->where('template_id', $tRecord->id)
						->where('column', $item->getAttribute('field'))
						->find();
					if(!$objectmap->loaded){
						$newmap = ORM::Factory('objectmap');
						$newmap->template_id = $tRecord->id;
						$newmap->type = $index;
						$newmap->index = ++$dbmapindexes[$index];
						$newmap->column = $item->getAttribute('field');
						$newmap->save();
					}

				}
			}
				}

		//	var_export($this->config);
		//$this->writeConfig();

		echo "\nPreparing to insert data.  Do you want to replace all CMS data? (Yes/no)\n";
		flush();
		ob_flush();
		$this->scanf('%s', $response);
		if($response == 'Yes'){
			$db->query('delete from pages');
			$db->query('alter table pages AUTO_INCREMENT = 1');
			$db->query('delete from content_smalls');
			$db->query('alter table content_smalls AUTO_INCREMENT = 1');
			$db->query('delete from content_mediums');
			$db->query('alter table content_mediums AUTO_INCREMENT = 1');
			$db->query('delete from content_larges');
			$db->query('alter table content_larges AUTO_INCREMENT = 1');
			flush();
			ob_flush();

			echo "\nInserting Data\n";
		$this->insertData($configArray['data']);

		}	else {
			echo "\nData Unchanged\n";
		}

	}

	public function insertData($dataInit, $parentId = 0){

		foreach($dataInit as $data){
			flush();
			ob_flush();
			$page = ORM::Factory('page');
			$template = ORM::Factory('template', $data['templatename']);
			if($template->id == 0){
				die("Bad template name ".$data['templatename']."\n");
			}
			$page->template_id = $template->id;
			$page->published = true;
			$page->parentid = $parentId;
			if(isset($data['content']['title'])){
				$page->slug = cms::createSlug($data['content']['title']);
			}
			$page->save();
			foreach($data['content'] as $field => $value){
				if($field === 0){
					die("Initializing content must be associative array at: $field => $value ");
					exit;
				}
				$page->contenttable->$field = $value;
				$page->contenttable->save();
			}
			//do recursive if it has children
			if(isset($data['children'])){
				$this->insertData($data['children'], $page->id);
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
