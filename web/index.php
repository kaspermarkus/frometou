<?php
header('Content-type: text/html; charset=iso-8859-1');
require_once("functions/system/mandatory.php");

/* If no document is selected, go to front */
if (!isset($_GET['did'])) {
	$_GET['did'] = 0;
}

$props = new propContainer($_GET['did']);

include_once("layout/layout.php");
?>
