<?php
require_once("system/authorize.php");
require_once("functions/cms_general.php");

$filename = "mappings_edit.php";
$id = "mid";

if (isset($_GET['save'])) {
	//if we have a valid id
	if ($_GET[$id] > 0) {
		$query = "UPDATE mapping SET did = \"".$_GET['did']."\", path = \"".$_GET['path']."\" ";
		$query .= "WHERE $id='".$_GET[$id]."'";
		//echo $query;
		mysql_query($query);
		header("location:$filename?$id=".$_GET[$id]);
	} else {		
		$query = "INSERT INTO mapping ( mid, did, path ) VALUES ";
		$query .= "('', \"".$_GET['did']."\", \"".$_GET['path']."\")";
		mysql_query($query);
		$query = "SELECT $id FROM mapping ORDER BY $id DESC";
		$row = mysql_fetch_row(mysql_query($query));
		header("location:$filename?$id=".$row[0]);
	}
 } else	if (isset($_GET[$id])) {
	$result = mysql_query("SELECT * FROM mapping WHERE $id=".$_GET[$id]);
	$row = mysql_fetch_assoc($result);
 }
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta content="text/html; charset=ISO-8859-1" http-equiv="content-type"/>
	<LINK REL="stylesheet" type="text/css" href="layout/css/general.css">
	<title>Edit/add Mappings</title>
	</head>
	<body>
	<H1>Edit/add Mappings</H1>
<A HREF='mappings_list.php'>Back to list of mappings</A>
	<HR>
	<BR>
	<FORM target="_self" method="get" action="<?php echo $filename; ?>" name="f1">
	<FIELDSET><LEGEND><B>Properties</B></LEGEND>
	<input type='hidden' name='<?php echo $id; ?>' value="<?php echo isset($_GET[$id])?$_GET[$id]:""; ?>">
	<TABLE>
	<TR><TH>path: </TH><TD><input size="80" name="path" value="<?php echo isset($row['path'])?$row['path']:""; ?>"></TD></TR>
	<TR><TH>document: </TH><TD><?php echo selectDocument(null, "did", 1, isset($row['did'])?$row['did']:null); ?></TD></TR>
	</TABLE>
	<INPUT TYPE="submit" value="save" name="save">
	</FIELDSET>
	</FORM>
<BR><A HREF='mappings_list.php'>Back to list of mappings</A>
	</body>
	</html>
