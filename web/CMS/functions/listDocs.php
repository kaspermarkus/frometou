<?php
require_once("functions/cms_general.php");

	$query = "SELECT did, ident FROM frometou_db.doc WHERE typeid = 1";
	$result = mysql_query($query) or die(mysql_error());
	while ($row = mysql_fetch_array($result)) {
		echo "<TR><TD><a href='editDocs.php?did=".$row['did']."'> ".$row['ident']."</a></TD></TR>";
	}

?>
