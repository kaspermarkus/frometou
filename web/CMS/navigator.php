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
<a href='main.php'>
<H3><?php echo "$SITE_INFO_WEB_NAME"; ?></H3>
<H4>Administration</H4>
<H4>Home</H4>
</a>
<br>
<HR>
</center>
<br>
<table>
<TR><H2>Contents</H2></TR>
<TR><TH>Documents<TH></TR>
<TR><TD><?php require_once("../CMS/functions/listDocs.php");?></TD></TR>
<TR><TD><?php require_once("../CMS/new_doc.php");?></TD></TR>
<TR><TD><a href="listMappings.php">Mappings</a></TD></TR>
</TABLE>
</BODY>
</HTML>
