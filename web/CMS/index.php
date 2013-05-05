<?php 
require_once("system/authorize.php");
?>

<html>
<head>
<meta content="text/html; charset=ISO-8859-1" http-equiv="content-type">
        <LINK REL="stylesheet" type="text/css" href="layout/css/general.css">

<title><?php echo $SITE_INFO_WEB_NAME; ?>  - administrative pages</title>
</head>
<frameset border="1"  cols="260, *">
	<frame name="navigation" src="navigator.php" border="0" marginheight="0" marginwidth="10px">
	<frame name="main" src="doc_edit.php" border="0" marginheight="0" marginwidth="10px">
</frameset>
</html>
