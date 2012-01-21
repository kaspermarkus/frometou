<?php
require_once("../functions/connect.php");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<HTML>
  <HEAD>
     <TITLE></TITLE>
     <LINK REL="stylesheet" type="text/css" href="../css/general.css" >
     <BASE TARGET="main">
  </HEAD>
<BODY class="navigation">
<div class="navigation">
<center>
<br>
<H3>thecolororange.net</H3>
<H4>Help</H4>
</CENTER>
<br>
<HR>
<UL>
<LI><A HREF='main.php?hid=1'>Usage</A></LI>
<?php
/* Fix usage part */
$query = "SELECT t1.linktext as lt1, t2.linktext as lt2, t1.hid as id1, t2.hid as id2 FROM help as t1, help as t2 WHERE t1.parent = 1 AND t2.parent = t1.hid";
$result = mysql_query($query);
echo "<UL>";
while ($row = mysql_fetch_assoc($result)) {
   if ($prevLt1 != $row['lt1']) {
       if ($prevLt1 != null) echo "</UL>\n";
       echo "<LI><A HREF='main.php?hid=".$row['id1']."'>".$row['lt1']."</LI>\n<UL>";
       $prevLt1 = $row['lt1'];
   }
   echo "<LI><A HREF='main.php?hid=".$row['id2']."'>".$row['lt2']."</A></LI>\n";
   
}
echo "</UL>\n";
echo "</UL>\n";
?>
<LI><A HREF='main.php?hid=2'>How do I...?</A></LI>
<?php
/* Fix usage part */
$query = "SELECT linktext, hid FROM help WHERE parent = 2";
$result = mysql_query($query);
echo "<UL>";
while ($row = mysql_fetch_assoc($result)) {
   echo "<LI><A HREF='main.php?hid=".$row['hid']."'>".$row['linktext']."</LI>\n";
}
echo "</UL>\n";
echo "</UL>\n";
?>
</UL>
</BODY>
</HTML>
