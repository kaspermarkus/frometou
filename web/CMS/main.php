<?php
require_once("../functions/system/siteInfo.php"); 
require_once("functions/cms_general.php");
require_once("functions/parsing.php");

//Unsetting the current Did in use
$_SESSION['ThisDid'] = null;
//Refreshing the navigation window, for new chonges to accur.
echo "<SCRIPT>parent.navigation.location.href = 'navigator.php';</script>";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<HTML>
  <HEAD>
     <TITLE></TITLE>
     <LINK REL="stylesheet" type="text/css" href="css/general.css" >
     <BASE TARGET="main">
  </HEAD>
<BODY class="navigation">
<center>
<BR>
	  <BR>
	  <BR>
	  <BR>
	  <BR>
<HR>
<br>
<H1><?php echo $SITE_INFO_WEB_NAME; ?></H1>
<H2>Administration</H2>
<br>
<HR>
</BODY>
</HTML>
