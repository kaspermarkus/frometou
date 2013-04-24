<?php
require_once("functions/authorize.php");
require_once("../functions/system/siteInfo.php");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<HTML>
  <HEAD>
     <TITLE></TITLE>
     <LINK REL="stylesheet" type="text/css" href="css/general.css" >
     <BASE TARGET="main">
  </HEAD>
<BODY class="navigation">
<div class="navigation">
<center>
<br>
<H3><?php echo "$SITE_INFO_WEB_NAME"; ?></H3>
<H4>Administration</H4>
<br>
<HR>
</center>
<br>
<table>
<TR><TH>Contents</TH></TR>
<TR><TH>Documents<TH></TR>
<TR><TD><?php require_once("../CMS/functions/listDocs.php");?></TD></TR>
<TR><TD><?php require_once("../CMS/new_doc.php");?></TD></TR>
<TR><TD><a href="listTypes.php">Types</a></TD></TR>
<TR><TD><a href="parent_menu.php">parent menu</a></TD></TR>
<!--
<TR><TD><a href="listImgs.php">Images</a></TD></TR>
<TR><TD><a href="listFiles.php">Files</a></TD></TR>
-->
<!-- <TR><TD><a href="listSupporters.php">Supporters</A></TD></TR>
<TR><TD><a href="listSpecialText.php">Special Text</A></TD></TR>
-->
<TR><TD><a href="listMappings.php">Mappings</a></TD></TR>
</TABLE>
<BR>
<table>
<TR><TH>Settings</TH></TR>
<TR><TD><a href="listDefaultLangs.php">default Languages</a></TD></TR>
</TABLE>
<BR>

<?php
//<table>
//<TR><TH>Secure actions</TH></TR>
//<TR><TD><a href="printMaillist.php">show maillist</A></TD></TR>
//</TABLE>
//<BR>
//<table>
//<TR><TH>Help</TH></TR>
//<TR><TD><a href="help/" TARGET="_blank">Help</a></TD></TR>
//</TABLE>
?>
</BODY>
</HTML>
