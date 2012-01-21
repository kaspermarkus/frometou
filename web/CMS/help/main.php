<?php

require_once("authorize.php");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<HTML>
  <HEAD>
     <TITLE></TITLE>
     <LINK REL="stylesheet" type="text/css" href="../css/general.css" >
     <BASE TARGET="main">
  </HEAD>
<BODY class="navigation">
<?php

if (!isset($_GET['hid'])) { ?>
<center>
  <BR>
  <BR>
  <BR>
  <BR>
  <BR>
  <HR>
  <br>
  <H1>thecolororange.net</H1>
  <H2>Help</H2>
  <br>
  <HR>
  <H3>Please select a topic in the menu to the left</h3>
<?php
} else {
   $query = "SELECT * FROM help WHERE hid = ".$_GET['hid'];
   $row = mysql_fetch_assoc(mysql_query($query));
   
   echo "<H1>".$row['linktext']."</H1><HR>";
   echo $row['body'];
}
?>
</BODY>
</HTML>
