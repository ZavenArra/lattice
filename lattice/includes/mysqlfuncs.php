<?

/*
 * Function: mysql_multiquery($sql)
 * Allows for a string containing multiple sql commands to be processed through mysql
 * */
function mysql_multiquery($sql){
	$sql = explode(";\n", $sql);
	//echo $sql;
	//echo "\n\n";
	foreach ($sql as $key => $val) {
		$rval = mysql_query($val);
		if(!$rval){
			echo mysql_error();
		}
	}
}
