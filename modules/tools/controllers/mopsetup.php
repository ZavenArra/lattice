<?

class mopSetup_Controller extends Controller {


	public function buildFrontendTemplates ($template=null) {

		$setup = Kohana::config('cms.modules');
		if($template){
			$filtered = array();
			$filtered[$template] = $setup[$template];
			$setup = $filtered;
		}	

		foreach($setup as $templatename => $items){
			$tfile = fopen('application/modules/site/views/site/'.$templatename.'.php', 'w');
			foreach($items as $item){
				if($item['type'] == 'module'){
					if(isset($item['controllertype']) && ($item['controllertype'] == 'listmodule') ){
						$output = '<ul id="'.$item['modulename'].'">'."\n";
						$output .= '<?for($i=0, $count=count($content['."'".$item['modulename']."'".']), $firstlast=" class=\"first\""; $i<$count && $item=$content['."'".$item['modulename']."'".'][$i]; $i++, $i<$count-1?$firstlast="":$firstlast=" class=\"last\""):?>'."\n";
						$output .= '<li<?=$firstlast;?>>'."\n";
						foreach(Kohana::config($item['modulename'].'.fields') as $field=>$map){
							$output .= '<?=$item['."'".$field."'".'];?>'."\n";
						}
						$output .= '</li>'."\n";
						$output .= '<?endfor;?>'."\n";
						$output .= "</ul>\n";
						fwrite($tfile, $output."\n");
					}

				} else { 
					fwrite($tfile, '<?=$content['."'".$item['field']."'".'];?>'."\n");
				}
			}
			/*
			 * fwrite($tfile, '<?print_r($content);?>');
			 */
			fclose($tfile);
		}
	}
}
