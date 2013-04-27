<?php
require_once(dirname(__FILE__)."/../../functions/system/siteInfo.php");
require_once($SITE_INFO_LOCAL_ROOT."functions/security.php");
require_once($SITE_INFO_LOCAL_ROOT."/CMS/system/doc.php");

require_once($SITE_INFO_LOCAL_ROOT."/CMS/modules/normal_page.php");
require_once($SITE_INFO_LOCAL_ROOT."/CMS/modules/hierarchy.php");
require_once($SITE_INFO_LOCAL_ROOT."/CMS/modules/mainmenu.php");

session_start(); // Starts the session


$_POST = secureInput($_POST);
$_GET = secureInput($_GET);

if (!($_SESSION['uname'] == "$SITE_INFO_CMS_UNAME" && $_SESSION['pass'] == "$SITE_INFO_CMS_PASS")) {
	echo "<HTML><BODY><SCRIPT LANGUAGE='javascript'>";
	echo "document.location = 'login.php?errorMsg=An error occured.. please login again'";
	echo "</SCRIPT></BODY></HTML>";
	die();
 } else {
	require_once("{$SITE_INFO_LOCAL_ROOT}functions/system/connect.php");
	if (!isset($_SESSION['lang'])) {
		$result = mysql_query("SELECT id FROM lang ORDER BY priority DESC");
		$row = mysql_fetch_row($result);
		$_SESSION['lang'] = $row[0];
	}
	require_once(dirname(__FILE__)."/../functions/functions.php");

	//update enabled modules from siteInfo file
	mysql_query("UPDATE module SET enabled=0"); //first disable all

	foreach ($SITE_INFO_MODULES_ENABLED as $mod) {
	    //ensure module is initialized
	    require_once("{$SITE_INFO_LOCAL_ROOT}CMS/modules/{$mod}_init.php");

	    $sql = "UPDATE module SET enabled=1 WHERE module_signature='$mod'";
	    //echo $sql."<br/>";
	    mysql_query($sql);
	}

}
?>
