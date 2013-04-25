<?php
require_once("system/mandatory.php");

function parse_html($did, $body) {
	global $_SESSION;
	global $SITE_INFO_PUBLIC_ROOT;
	$body=stripslashes($body);
	/** FIX internal LINKS **/
	$regexp = "#href=['\"]/[a-zA-Z]*/page([0-9]+)['\"]#i"; //[a-zA-Z]{0,5}/?page([0-9]+)'>#";
	$body =  preg_replace($regexp, "href='".$SITE_INFO_PUBLIC_ROOT.$_SESSION['lang']."/page".'$1'."'", $body);
	return $body;
}
?>
