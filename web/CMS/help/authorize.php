<?php
session_start(); // Starts the session

if (!($_SESSION['uname'] == "vagn" && $_SESSION['pass'] == "tuborg08")) {
	echo "<HTML><BODY><SCRIPT LANGUAGE='javascript'>";
	echo "document.location = 'login.php?errorMsg=An error occured.. please login again'";
	echo "</SCRIPT></BODY></HTML>";
	die();
 } else {
	require_once("../functions/connect.php");
	if (!isset($_SESSION['lang'])) {
		$result = mysql_query("SELECT lang FROM lang ORDER BY priority DESC");
		$row = mysql_fetch_row($result);
		$_SESSION['lang'] = $row[0];
	}
 }
?>
