<?php
require_once("functions/cms_general.php");

$filename = "editLangs.php";
$id = "lid";

if (isset($_GET['save'])) {
	//if we have a valid id
	if ($_GET[$id] > 0) {
		$query = "UPDATE lang SET lname = \"".$_GET['lname']."\", shorthand = \"".strtolower($_GET['shorthand'])."\", ";
		$query .= "thumbnail_path = \"".$_GET['thumbnail_path']."\", priority = \"".$_GET['priority']."\" WHERE langid='".$_GET[$id]."'";
		mysql_query($query);
		header("location:$filename?$id=".$_GET[$id]);
	} else {		
		$query = "INSERT INTO lang ( lname, shorthand, thumbnail_path, priority ) VALUES ";
		$query .= "(\"".$_GET['lname']."\", \"".strtolower($_GET['shorthand'])."\", ";
		$query .= "\"".$_GET['thumbnail_path']."\", \"".$_GET['priority']."\")";
		mysql_query($query);
		$query = "SELECT langid FROM lang ORDER BY langid DESC";
		$row = mysql_fetch_row(mysql_query($query));
		header("location:$filename?$id=".$row[0]);
	}
 } else	if (isset($_GET[$id])) {
	$result = mysql_query("SELECT * FROM lang WHERE langid=".$_GET['lid']);;
	$row = mysql_fetch_assoc($result);
 }
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta content="text/html; charset=ISO-8859-1" http-equiv="content-type"/>
	<LINK REL="stylesheet" type="text/css" href="css/general.css">
	<title>Edit/add languages</title>
	</head>
	<body>
	<H1>Edit/add Languages</H1>
<A HREF='listLangs.php'>Back to list of languages</A>
	<HR>
	<BR>
	<FORM target="_self" method="get" action="<?php echo $filename; ?>" name="f1">
	<FIELDSET><LEGEND><B>Properties</B></LEGEND>
	<input type='hidden' name='<?php echo $id; ?>' value="<?php echo $_GET[$id]; ?>">
	<TABLE>
	<TR><TH>name: </TH><TD><input size="80" name="lname" value="<?php echo $row['lname'] ?>"></TD></TR>
	<TR><TH>shorthand: </TH><TD><input size="80" name="shorthand" value="<?php echo $row['shorthand'] ?>"></TD></TR>
	<TR><TH>flag: </TH><TD><input size="80" name="thumbnail_path" value="<?php echo $row['thumbnail_path']; ?>"></TD></TR>
	<TR><TH>priority: </TH><TD><input size="80" name="priority" value="<?php echo $row['priority'] ?>"></TD></TR>
	</TABLE>
	<INPUT TYPE="submit" value="save" name="save">
	</FIELDSET>
	</FORM>
<BR><A HREF='listLangs.php'>Back to list of languages</A>
	</body>
	</html>
