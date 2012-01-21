<?php
require_once("authorize.php");
require_once("../functions/functions.php");

$filename = "editSupporters.php";
$id = "sid";

if (isset($_GET['save'])) {
	//if we have a valid id
	if ($_GET[$id] > 0) {
		$query = "UPDATE supporters SET fullname = \"".$_GET['fullname']."\", city = \"".$_GET['city']."\", ";
		$query .= "country = \"".$_GET['country']."\", comments = \"".$_GET['comments']."\", active=\"".$_GET['active']."\" WHERE $id='".$_GET[$id]."'";
		mysql_query($query);
		header("location:$filename?$id=".$_GET[$id]);
	} 
 } else if (isset($_GET['delete'])) {
	$query = "DELETE FROM supporters WHERE $id = ".$_GET[$id];
	mysql_query($query);
	header("location:listSupporters.php");
 } else	if (isset($_GET[$id])) {
	$result = mysql_query("SELECT * FROM supporters WHERE $id=".$_GET[$id]);
	$row = mysql_fetch_assoc($result);
 }
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta content="text/html; charset=ISO-8859-1" http-equiv="content-type"/>
	<LINK REL="stylesheet" type="text/css" href="css/general.css">
	<title>Edit supporters</title>
	</head>
	<body>
	<H1>Edit supporters</H1>
<A HREF='listSupporters.php'>Back to list of supporters</A>
	<HR>
	<BR>
	<FORM target="_self" method="get" action="<?php echo $filename; ?>" name="f1">
	<FIELDSET><LEGEND><B>Properties</B></LEGEND>
	<input type='hidden' name='<?php echo $id; ?>' value="<?php echo $_GET[$id]; ?>">
	<TABLE>
	<TR><TH>name: </TH><TD><input size="80" name="fullname" value="<?php echo $row['fullname'] ?>"></TD></TR>
	<TR><TH>city: </TH><TD><input size="80" name="city" value="<?php echo $row['city'] ?>"></TD></TR>
	<TR><TH>country: </TH><TD><input size="80" name="country" value="<?php echo $row['country'] ?>"></TD></TR>
	<TR><TH>comments: </TH><TD><input size="80" name="comments" value="<?php echo $row['comments'] ?>"></TD></TR>
	<TR><TH>active: </TH><TD><input size="80" name="active" value="<?php echo $row['active'] ?>"></TD></TR>
	</TABLE>
	<INPUT TYPE="submit" value="save" name="save">
	<INPUT TYPE="submit" value="delete" name="delete">
	</FIELDSET>
	</FORM>
<BR><A HREF='listSupporters.php'>Back to list of languages</A>
	</body>
	</html>
