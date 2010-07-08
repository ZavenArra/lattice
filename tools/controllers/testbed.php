<?

Class TestBed_Controller extends Controller {

	public function __construct(){
		//sanity checks
		$notSane = null;
		if(!Kohana::config('testbed.dbPrefix')){
			$notSane .= "testbed.dbPrefix is not set: This configuration must be set in the config/testbed.php file to indicate the global database name prefix for the project\n";
		}

		if(!is_array(Kohana::config('testbed.tablesToRevert'))
			 || !count(Kohana::config('testbed.tablesToRevert'))){
			$notSane .= "test.tablesToRevert is empty: This configuration muest be set in the config/testbed.php file to indicate which tables to copy back from the testbed database\n";
		}
		if($notSane){
			die(nl2br($notSane));
		}

		$this->testDatabase = Kohana::config('testbed.dbPrefix').'test.';
		$this->testbedDatabase = Kohana::config('testbed.dbPrefix').'testbed.';
		parent::__construct();
	}

	public function index(){
		$this->template = new View('testbedIndex');
		$this->template->render(true);
		exit;
	}
	

	public function revertTestingData(){
		$db = new Database();
		//drop tables
		foreach(Kohana::config('testbed.tablesToRevert') as $table){
			$db->query('drop table if exists '.$this->testDatabase.$table);
		}
		//get data from testarea
		foreach(Kohana::config('testbed.tablesToRevert') as $table){
			$db->query('create table '.$this->testDatabase.$table.' like '.$this->testbedDatabase.$table);
			$db->query('insert into  '.$this->testDatabase.$table.' select * from '.$this->testbedDatabase.$table);
		}
		echo 'done';
		exit;
		
	}
}
