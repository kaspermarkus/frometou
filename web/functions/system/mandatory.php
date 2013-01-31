<?php
/*
This file should be from index.php (generally any php file facing the user
and requiring the basic functionality of the system. Amonst other it will
get the basic site info and connect to the database
*/
session_start();
require_once("siteInfo.php");
require_once("connect.php");
require_once("document_properties.php");

//If no session language is set, set it:
if (!isset($_SESSION['lang'])) {
   	$sql = "SELECT id FROM lang ORDER BY priority DESC";
    $row = mysql_fetch_assoc(mysql_query($sql));
	$_SESSION['lang'] = $row['id'];
}

//If session language should be changed:
if (isset($_GET['lang']) && ($_GET['lang'] != $_SESSION['lang'])) {
	$_SESSION['lang'] = $_GET['lang'];
}

function changeLangLink($lang) {
        global $SITE_INFO_PUBLIC_ROOT;
        $path = $SITE_INFO_PUBLIC_ROOT;
	$path .= $lang."/";
        if ($_GET['did'] != null) {
                $path .= "page".$_GET['did'];
        }
        return $path;
}

function pageLink($did, $lang = null) {
        global $SITE_INFO_PUBLIC_ROOT;
        global $_SESSION;
	$path = $SITE_INFO_PUBLIC_ROOT;
        $path .= $_SESSION['lang']."/";
	$path .= "page${did}";
	$path .= ($lang)?"_$lang":"";
	return $path;
}

?>
