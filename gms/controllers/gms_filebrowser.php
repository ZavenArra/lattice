<?
require_once('../includes/resample.php');
class GMS_FileBrowser extends Featurette{

	function GMS_FileBrowser($featurettename){
			parent::Featurette($featurettename);
	}

	function buildFeaturette(){
		parent::buildFeaturette();


		$this->getDirectoryAssigns();

	}

	function doActions(){
		if($_FILES['uploadfile']){
			update_image('uploadfile', '/../uploads/'.$_FILES['uploadfile']['name']);
		}
	}

	function doAjax(){
		switch($_REQUEST['action']){
			case 'getDirectory':
				$this->getDirectoryAssigns();		
				$this->loadTemplate('gms_filebrowser');
				return $this->toHTML();
				break;

			case 'upload':
				$ftmp = $_FILES['attachfile']['tmp_name'];
				$oname = $_FILES['attachfile']['name'];
				$directory = $_REQUEST['directory'];

				if(file_exists("../uploads/{$directory}$oname")){
					$xarray = explode('.', $oname);
					$nr = count($xarray);
					$ext = $xarray[$nr-1];
					$name = array_slice($xarray, 0, $nr-1);
					$name = implode('.', $name);
					$i=1;
					for(; file_exists("../uploads/{$directory}$name".$i.'.'.$ext); $i++){}
					$savename = $name.$i.'.'.$ext;
				} else {
					$savename = $oname;
				}

				if(!move_uploaded_file($ftmp, '../uploads/'.$directory.$savename)){
					echo 'file upload error';
				}
				ob_start()
				?>
				<script type="text/javascript">
					window.parent.fb.reload();
				</script>
				<?php
					$js = ob_get_clean();
				return $js;
				break;
		}
	}

	function getDirectoryAssigns(){
		$directories = array();
		$files = array();

		$pathhistory = explode('/', $_REQUEST['directory']);
		if($pathhistory[count($pathhistory)-2] == '..'){
			unset($pathhistory[count($pathhistory)-1]);
			unset($pathhistory[count($pathhistory)-1]);
			unset($pathhistory[count($pathhistory)-1]);
			$currentdirectory = implode('/', $pathhistory);	
			if(strlen($currentdirectory)){
				$currentdirectory = $currentdirectory . '/';	
			}
		} else {
			$currentdirectory = $_REQUEST['directory'];
		}

		$dir = opendir(FULLPATH . '/../uploads/'.$currentdirectory);
		//sort the damn files by alpha
		while($item = readdir($dir)){
			if(strpos($item, '.') === 0)
				continue;

			if(is_dir(FULLPATH.'/../uploads/'.$currentdirectory.$item)){
				$directories[] = array(
					'directory' =>$currentdirectory.$item,
					'name' => $item
				);
			} else {
				$data['filename'] = $item;
				$data['path'] = $fullpathitem;
				$files[] = $data;
			}
		}
		$this->assigns['directories'] = $directories;
		$this->assigns['files'] = $files;
		$this->assigns['currentdirectory'] = $currentdirectory;

		
	}
	
}

?>
