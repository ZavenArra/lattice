<?
set_error_handler(array('Cli', 'error_handler'), E_ALL);
//set_exception_handler(('Cli::exception_handler'));
require('/home/deepwinter/dev/deepwinter/yaml/lib/sfYaml.php');
require('/home/deepwinter/dev/deepwinter/yaml/lib/sfYamlParser.php');

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
		echo "Reading application/config/siteconfig.yaml\n";
		flush();
		ob_flush();
		
		$yaml = new sfYamlParser();
		try {
			$configArray = $yaml->parse(file_get_contents('application/config/siteconfig.yaml'));
		}
		catch (InvalidArgumentException $e) {
			// an error occurred during parsing
			echo "Unable to parse the YAML string: ".$e->getMessage();
			flush();
			ob_flush();
			exit;
		}


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
			$db->query('alter table templates AUTO_INCREMENT = 1');
		}




		//build templates
		foreach($configArray['templates'] as $template){
			$dbmapindexes = array(
				'field'=>0,
				'file'=>0,
				'date'=>0,
				'flag'=>0,
			);

			//config entries
			if(!isset($template['templatename'])){
				echo 'Missing templatename attribute in: ';
				print_r($template);
				exit;
			}
			$this->config['cms'][$template['templatename']] = array();
			$this->config['cms_dbmap'][$template['templatename']] = array();
			$this->config['cms_templates'][$template['templatename']] = array();
			$this->config['cms_images'][$template['templatename']] = array();

			//this should be part of a general validation
			//
			/*
			if(!isset($template['parameters'])){
				echo 'Missing parameters attribute in: ';
				print_r($template);
				flush();
				ob_flush();
				exit;
			} else
			 */
			if(is_array($template['parameters'])){
			//loop through items
				foreach($template['parameters'] as $item){
					if($item['type'] == 'module'){
						$entry = array(
							'type'=>$item['type'],
							'modulename'=>$item['modulename'],
							'controllertype'=>$item['controllertype'],
						);
						$this->config['cms']['modules'][$template['templatename']][] = $entry;

						switch($item['controllertype']){
						case 'listmodule':
							$this->buildListModuleConfig($item);
							break;
						}


					} else {

						//cms mopui elements

						//handle dbmap
						$index = null;
						switch($item['type']){
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
							$index = $item['type'];
							break;
						}	
						$this->config['cms_dbmap'][$template['templatename']][$item['field']] = $index.++$dbmapindexes[$index];

						//handle cms
						$entry = array(
							'type'=>'',
							'field'=>'',
							'label'=>'',
							'class'=>'',
							'tag'=>'',
						);
						foreach(array_keys($entry) as $key){
							$entry[$key] = $this->valueIfSet($key, $item);
						}

						$classes = array(
							'rows',
							'cols',
						);
						foreach($classes as $aClass){
							if($value = $this->valueIfSet($aClass, $item)){
								$entry['class'].=$aClass.'-'.$value;
							}
						}

						switch($item['type']){
						case 'singlefile':
						case 'singleImage':
							$entry['extensions'] = $this->valueIfSet('extensions', $item);
							$entry['maxlength'] = $this->valueIfSet('maxlength', $item);
							break;
						case 'radioGroup':
							$entry['radios'] = $this->valueIfSet('radios', $item);
							$entry['groupLabel'] = $this->valueIfSet('groupLabel', $item);
							$entry['radioname'] = $this->valueIfSet('radioname', $item);
							break;
						case 'multiSelect':
							$entry['options'] = $this->valueIfSet('options', $item);
							$entry['unsetLabel'] = $this->valueIfSet('unsetLabel', $item);
							break;
						}

						$this->config['cms']['modules'][$template['templatename']][] = $entry;

						//cms images
						if($item['type']=='singleImage'){
							$entry = array();
							$entry['extensions'] = $this->valueIfSet('extensions', $item);
							if(isset($item['sizes'])){
								$entry['resize']['imagesizes'] = $item['sizes'];
							} else {
								$entry['resize']['imagesizes'] = array();
							}
							$this->config['cms_images'][$template['templatename']][$item['field']] = $entry;
						}



					}
				}
			}
			//handle cms_templates config
			$entry = array(
				'addable_objects' => array(),
				'allow_delete'=>0,
				'allow_toggle_publish'=>0,
				'landing'=>'DEFAULT', //DEFAULT, NO_LANDING, USE_PAGE_TITLE
				'allow_sort'=>true,
			);

			print_r($template);

			if(isset($template['addable_objects']) 
				&& is_array($template['addable_objects']) 
					&& count($template['addable_objects']) )
			{
			print_r($template['addable_objects']);
				$entry['addable_objects'] = $template['addable_objects'];
			}

			$entry['allow_delete'] = $this->valueIfSet('allow_delete', $template);
			$entry['allow_sort'] = $this->valueIfSet('allow_sort', $template);
			$entry['allow_toggle_publish'] = $this->valueIfSet('allow_toggle_publish', $template);
			$landing = $this->valueIfSet('landing', $template);
			$entry['landing'] = $landing ? $landing : 'DEFAULT';
			$this->config['cms_templates'][$template['templatename']] = $entry;
			print_r($entry);

			//set up the database
			if($this->doTemplateDatabase){
				$tRecord = ORM::Factory('template');
				$tRecord->templatename = $template['templatename'];
				if($dbmapindexes['field'] <= 5 && $dbmapindexes['file'] <= 2){
					$contenttable = 'content_small';
				} else if($dbmapindexes['field'] <= 10 && $dbmapindexes['file'] <= 2){
					$contenttable = 'content_medium';
				} else if($dbmapindexes['field'] <= 15 && $dbmapindexes['file'] <= 2){
					$contenttable = 'content_large';
				} else {
					print_r($dbmapindexes);
					die('Too many fields to content_large');
				}
				$tRecord->contenttable = $contenttable;
				if(!isset($template['nodetype'])){
					echo 'nodetype must be set at: ';
					print_r($template);
					flush();
					ob_flush();
					exit;
				}
				$tRecord->nodetype = $this->valueIfSet('nodetype', $template);
				$tRecord->save();
			}
		}
		
	//	var_export($this->config);
		$this->writeConfig();

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
