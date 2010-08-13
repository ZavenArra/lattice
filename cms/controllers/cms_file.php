<?
class Cms_File_Controller extends Controller{

	public function __construct(){
		parent::__construct();
		if(Kohana::config('mop.staging')){
			$this->mediapath = Kohana::config('mop.stagingmediapath');
		} else {
			$this->mediapath = Kohana::config('mop.mediapath');
		}
	}

	public function download($fileid){
		$file = ORM::Factory('file', $fileid);

		//check access
		//don't have page wise access checking at this point



		$filename = $this->mediapath . $file->filename;
		$ctype = $file->mime;


		if (!file_exists($filename)) {
			die("NO FILE HERE");
		}

		header("Pragma: public");
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Cache-Control: private",false);
		header("Content-Type: $ctype");
		header("Content-Disposition: attachment; filename=\"".basename($filename)."\";");
		header("Content-Transfer-Encoding: binary");
		header("Content-Length: ".@filesize($filename));
		set_time_limit(0);
		@readfile("$filename") or die("File not found.");	
		exit;
	}


	public function directlink($fileid){
		$file = ORM::Factory('file', $fileid);

		$filename = $this->mediapath.$file->filename;
		$ctype = $file->mime;


		if (!file_exists($filename)) {
			die("NO FILE HERE");
		}

		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Cache-Control: private",false);
		header("Content-Type: $ctype");
		header("Content-Transfer-Encoding: binary");
		header("Content-Length: ".@filesize($filename));
		header("Content-Disposition: inline;  filename=\"".basename($filename)."\";");
		set_time_limit(0);
		@readfile("$filename") or die("File not found.");	
		exit;
	}

}


