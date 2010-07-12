<?
set_error_handler(array('Cli', 'error_handler'), E_ALL);
//set_exception_handler(('Cli::exception_handler'));
require('/home/deepwinter/dev/deepwinter/yaml/lib/sfYaml.php');
require('/home/deepwinter/dev/deepwinter/yaml/lib/sfYamlParser.php');

Class Frontend_Controller extends Controller {

	public function __construct(){
		parent::__construct();
	}

	public function index(){
		echo "Configuring Frontend\n";
		echo "Reading application/config/frontend.yaml\n";
		
		flush();
		ob_flush();
		
		$yaml = new sfYamlParser();
		try {
			$configArray = $yaml->parse(file_get_contents('application/config/frontend.yaml'));
		}
		catch (InvalidArgumentException $e) {
			// an error occurred during parsing
			echo "Unable to parse the YAML string: ".$e->getMessage();
			flush();
			ob_flush();
			exit;
		}

		print_r($configArray);
		foreach($configArray['views'] as $view ){
			touch('application/modules/site/views/site/'.$view['view'].'.php');
			ob_start();
			echo "<p>Main Content</p>";
			echo "<ul>\n".
				    "<?foreach(\$content['main'] as \$field => \$value):?>\n".
							"<li><?=\$field;?>: <?=\$value;?></li>\n".
					  "<?endforeach;?>\n".
					 "</ul>\n\n";
			foreach($view['extendeddata'] as $edata){
			echo "<p>{$edata['label']} Content</p>";
				echo "<?foreach(\$content['{$edata['label']}'] as \$item):?>\n".
						"<ul>\n".
						"<?foreach(\$item as \$field=>\$value):?>\n".
							"<li><?=\$field;?>: <?=\$value;?></li>\n".
						"<?endforeach;?>\n".
						"</ul>\n".
					"<?endforeach;?>\n\n";
			}
			$html = ob_get_contents();
			ob_end_clean();
			$file = fopen('application/modules/site/views/site/'.$view['view'].'.php', 'w');
			fwrite($file, $html);
			fclose($file);
		}



	}

}
