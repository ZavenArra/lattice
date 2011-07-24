<?

Class Initializer_RootGraph {

	public function initialize(){
      try {
         ORM::Factory('object');
      } catch (Exception $e) {
         if ($e->getCode() == 1146) { //code for table doesn't exist
            $sqlFile = Kohana::find_file('config', 'graph-mysql', $ext = 'sql');
            $sql = file_get_contents($sqlFile[0]);
						mysql_multiquery($sql);	


            $sqlFile = Kohana::find_file('config', 'tags-mysql', $ext = 'sql');
            $sql = file_get_contents($sqlFile[0]);
						mysql_multiquery($sql);	
         }
      }
	}

}
