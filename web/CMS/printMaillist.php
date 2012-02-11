<?php
require_once("authorize.php");
require_once("../functions/functions.php");
require_once("../functions/siteInfo.php");
require_once("../functions/parsing.php");

/* --------- if delete button has been pushed --------- */
if (isset($_POST['untill'])) {
	mysql_query("DELETE FROM maillist WHERE ID <= ".$_POST['untill']);
	header("location:printMaillist.php");
}

//retrieve entries from DB
$result = mysql_query("SELECT * FROM `maillist` ORDER BY ID DESC");
$row = mysql_fetch_assoc($result);

?>

<HTML>
<HEAD>
<meta content="text/html; charset=ISO-8859-1" http-equiv="content-type">
	<LINK REL="stylesheet" type="text/css" href="css/general.css">
	<title>Show mailling list entries</title>

<SCRIPT LANGUAGE='javascript'>
	 function confirmer() {
		 return confirm("Are you sure you want to delete all visible persons on this list .. this cannot be undone");
	 }
</SCRIPT>
</HEAD>
	<BODY>
<H1>signups for the maillinglist</h1>
<HR>
<H4>Below is a list of subscribers for the maillinglist. They are printet like this<BR><BR>
Full Name1;street of first;cityname1;postal1;country1;email@first.person;comment1<BR>
Full Name2;street of secon;cityname2;postal2;country2;email@second.perso;comment2<BR>
<BR>
Hitting the deletebutton will delete ALL the entries on this page and CANNOT be undone!!!!
<FORM NAME='form1' METHOD='POST' onSubmit="javascript:return confirmer()">
<INPUT TYPE='hidden' NAME='untill' VALUE="<?php echo $row['ID'];?>">
<INPUT TYPE='submit' VALUE='Delete visible'>
</FORM>
</H4>
<HR>
<SMALL>
<?php

do {
   echo $row['name'].";".$row['street'].";".$row['city'].";".$row['postal'].";".$row['country'].";".$row['email'].";".$row['comment']."<BR>";
} while ($row = mysql_fetch_assoc($result));
?>
</SMALL>
<HR>
</BODY>
<BODY>
