<?php
header('Content-type: text/html; charset=iso-8859-1');
require_once("functions/general.php");
require_once("functions/path.php");
require_once("functions/display.php");

/* If no document is selected, go to front */
if (!isset($_GET['did'])) {
	$_GET['did'] = 0;
}

$props = getDocumentProperties($_GET['did']);

$pagetitle = $props['pagetitle'];

include_once("layout/layout.php");
?>
