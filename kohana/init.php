<?

//we should find a better spot to declare this code in a minute
function mysql_multiquery($sql){
	$sql = explode(";\n", $sql);
	echo $sql;
	echo "\n\n";
	foreach ($sql as $key => $val) {
		$rval = mysql_query($val);
		if(!$rval){
			echo mysql_error();
		}
	}
}
