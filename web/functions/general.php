<?php
session_start();
require_once("functions/siteInfo.php");
require_once("functions/connect.php");
//print_r($_SESSION);
//If no session language is set, set it:
if (!isset($_SESSION['lang'])) {
   	$sql = "SELECT lang FROM lang ORDER BY priority DESC";
        //echo mysql_query($sql);
        $row = mysql_fetch_row(mysql_query($sql));
//        header("location: ".changeLangLink($row[0]));
	echo "SETTING SESSION FROM ".$_SESSION['lang']." TO ".$row[0];
	$_SESSION['lang'] = $row[0];
}
//print_r($_SESSION);
//If session language should be changed:
if ($_GET['lang'] != $_SESSION['lang']) {
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
