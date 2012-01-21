<?php
header('Content-type: text/html; charset=iso-8859-1');
require_once("functions/documentBase.php");
require_once("functions/connect.php");
require_once("functions/listings.php");
require_once("functions/path.php");
require_once("functions/display.php");
require_once("functions/siteInfo.php");

/* update counter */
//if (!isset($_COOKIE["counter"])) {
//	setcookie("counter", "counted", time()+60*60*24);
//	$query = "UPDATE counter SET countervalue = (countervalue+1) WHERE countertype='daily'";
//	mysql_query($query);
//}

/* check if lang is set, else set to default */
if (!isset($_GET['lang'])) {
	$sql = "SELECT shorthand FROM lang ORDER BY priority DESC";
	//echo mysql_query($sql);
	$row = mysql_fetch_row(mysql_query($sql));
	if (isset($_GET['did'])) {
		$link = "page".$_GET['did'];
		if (isset($_GET['tmplang'])) {
			$link .= "_".$_GET['tmplang'];
		}
	}
	header("location:".$publicRoot.$row[0]."/".$link);
 }

/* If no document is selected, go to front */
if (!isset($_GET['did'])) {
	$_GET['did'] = 0;
}

$tmp = getDocumentProperties($_GET['did']);
$main_trans = $tmp['main'];

foreach ($tmp['tnames'] as $tid=>$tname) {
	$tmpimg = "<IMG SRC='".$publicRoot.$tmp['tpaths'][$tid]."'";	
	
	if ($tmp['usedlang'] != $tid) {
		$translations .= "<A HREF='".pageLink(null, null, $tid)."'>$tmpimg CLASS='translationflags'></A>";
	} 
	$translations .= "&nbsp;";
}
$parents = $tmp['parents'];
unset($tmp);
$pagetitle = $main_trans['pagetitle'];
$header = $main_trans['header'];
$postheader = $main_trans['postheader'];
$body .= $main_trans['body'];

/* --------------------------------------- fix default language flags ------------------------------------------------ */
$query = "SELECT lang.langid, lang.shorthand, images.iid, images.small, lang.lname FROM lang, defaultlangs, images WHERE defaultlangs.langid = lang.langid AND";
$query .= " images.iid = lang.iid ORDER BY lang.priority DESC";
$result = mysql_query($query);
while ($row = mysql_fetch_assoc($result)) {

	/*$img = "<IMG SRC='".$publicRoot.$row['small']."'";	
	
	if ($_GET['lang'] != $row['shorthand']) {
		$defaultflags .= "<A HREF='".pageLink(null, $row['shorthand'], null)."'>$img CLASS='defaultflags-regular'></A>";
	} else {
		$defaultflags .= "$img CLASS='defaultflags-selected'>";
		}*/
	if ($defaultflags != "") $defaultflags .= "|";
	if ($_GET['lang'] != $row['shorthand']) {
		$defaultflags .= "<A HREF='".pageLink(null, $row['shorthand'], null)."' CLASS='NE_FLAGS'>".$row['lname']."</A>";
	} else {
		$defaultflags .= "<B><A HREF='".pageLink(null, $row['shorthand'], null)."' CLASS='NE_FLAGS'>".$row['lname']."</A></B>";
	}
 }

include_once("layout/layout.php");
?>
