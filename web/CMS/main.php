<?php
require_once("system/authorize.php"); 


//Unsetting the current Did in use
$_SESSION['doc'] = null;
$_SESSION['module'] = null;
$_SESSION['did'] = null;

//Refreshing the navigation window, for new chonges to accur.
echo "<SCRIPT>parent.navigation.location.href = 'navigator.php';</script>";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<HTML>
  <HEAD>
     <TITLE></TITLE>
     <LINK REL="stylesheet" type="text/css" href="layout/css/general.css" >
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
Through this site you will be apple to modify the page, after your needs<br><br>
On this page you will find links to toturials, and guides on how to use administrate your webpage.
<hr>

</BODY>
</HTML>
