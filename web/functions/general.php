<?php
require_once("functions/siteInfo.php");
require_once("functions/connect.php");

//If no session language is set, set it:
if (!isset($_SESSION['lang'])) {
   	$sql = "SELECT lang FROM lang ORDER BY priority DESC";
        //echo mysql_query($sql);
        $row = mysql_fetch_row(mysql_query($sql));
        $_SESSION['lang'] = $row[0];
}
//If session language should be changed:
if ($_GET['lang'] != $_SESSION['lang']) {
	$_SESSION['lang'] = $_GET['lang'];
}
?>
