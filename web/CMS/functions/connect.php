<?php
//connects to the database with the given parameters:
function connectDB($dbhost, $db_name, $username, $password) {
	//get connection to host:
	$connection = mysql_connect($dbhost, $username, $password);
	//and connect to the given database
	if (!mysql_select_db($db_name, $connection)) {
		//print error if unsuccesfull
		echo "connection could not be established";
		die(mysql_error());
	}
  }
?>
