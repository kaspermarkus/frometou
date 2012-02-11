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
		$path .= $_GET['lang']."/page".$did;
		if ($tmplang != $_GET['lang'])
			$path .= "_".$tmplang;
		return $path;
	} else if ($did != null) {
		return $path.$_GET['lang']."/page".$did;
	} else if ($tmplang != null) {
		$path .= $_GET['lang']."/page".$_GET['did'];
		if ($tmplang != $_GET['lang'])
			$path .= "_".$tmplang;
		return $path;
	}
}
?>