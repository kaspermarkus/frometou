<?php
require_once("system/authorize.php");
require_once("../CMS/functions/listDocs.php");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<HTML>
  <HEAD>
     <TITLE></TITLE>
     <LINK REL="stylesheet" type="text/css" href="layout/css/general.css" >
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
<ul id='left_menu'>
    <li id='header'>Documents</li>
    <ul>
        <?php 
            listDocs($_SESSION['did']); 
            //availableLang();
        ?>
        <li><?php require_once("../CMS/doc_new.php");?></li>
    </ul>
    <li id='header'>Other</li>
    <ul>
        <li><a href="listMappings.php">Mappings</a></li>
    </ul>
</BODY>
</HTML>
