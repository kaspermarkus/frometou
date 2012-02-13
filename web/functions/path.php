<?php
require_once("siteInfo.php");

function pageLink($did, $lang, $tmplang) {
	global $SITE_INFO_PUBLIC_ROOT;
	$path = $SITE_INFO_PUBLIC_ROOT;
	
	if ($lang != null) {
		$path .= $lang."/";
		if ($_GET['did'] != null) {
			$path .= "page".$_GET['did'];
		}
		return $path;		
	} else if ($did != null && $tmplang != null) {
		$path .= $_SESSION['lang']."/page".$did;
		if ($tmplang != $_SESSION['lang'])
			$path .= "_".$tmplang;
		return $path;
	} else if ($did != null) {
		if ($did == 0) {
			return $path.$_SESSION['lang']."/";
		} else {
			return $path.$_SESSION['lang']."/page".$did;
		}
	} else if ($tmplang != null) {
		$path .= $_SESSION['lang']."/page".(($_GET['did'] == '') ? "0" : $_GET['did']);
		if ($tmplang != $_SESSION['lang'])
			$path .= "_".$tmplang;
		return $path;
	}
}
?>
