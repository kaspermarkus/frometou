<?php
require_once("functions/cms_general.php");

$filename = "editTypes.php";
$id = "tid";

/* ------------ if new language chosen ------------ */
if (isset($_GET['lang'])) {
	echo "AAAA";
	$_SESSION['lang'] = $_GET['lang'];
	if (isset($_GET[$id])) {
		$params = "?$id=".$_GET[$id];
	}
	header("location:".$filename.$params);
 }

/* ------------- if form is submitted -------------- */
if (isset($_GET['singlesave'])) {
	//if the id and the language version exists
	if ($_GET[$id] > 0 && mysql_num_rows(mysql_query("SELECT * FROM dtype_v WHERE $id=".$_GET[$id]." AND lang=".$_SESSION['lang'])) > 0) {
		$query = "UPDATE dtype_v SET ";
		$query .= "tname = \"".$_GET['tname']."\"";
		$query .= " WHERE $id = ".$_GET[$id];
		$query .= " AND lang = ".$_SESSION['lang'];
		mysql_query($query);
		header("location:$filename?$id=".$_GET[$id]);
	//if the id exist, but no language version exist
	} else if ($_GET[$id] > 0) { 
		$query = "INSERT INTO dtype_v ( tid, lang, tname ) VALUES ( '".$_GET[$id]."', '".$_SESSION['lang']."', '".$_GET['tname']."' )";
		mysql_query($query);
		header("location:$filename?$id=".$_GET[$id]);
	//if neither id, nor language exist .. create completely new
	} else {
		$query = "INSERT INTO dtype (tid, ident, priority) VALUES ( '', '".$_GET['ident']."', '".$_GET['priority']."' )";
		mysql_query($query);
		$result = mysql_query("SELECT $id FROM dtype ORDER BY $id DESC");
		$result = mysql_fetch_row($result);
		$query = "INSERT INTO dtype_v ( tid, lang, tname ) VALUES ( '$result[0]', '".$_SESSION['lang']."', '".$_GET['tname']."' )";
		mysql_query($query);
		header("location:$filename?$id=$result[0]");
	}
 } else if (isset($_GET['multisave'])) {
	//if no we have a valid id
	if ($_GET[$id] > 0) {
		$query = "UPDATE dtype SET priority = ".$_GET['priority'].", ident = '".$_GET['ident']."' WHERE $id='".$_GET[$id]."'";
	//	echo $query;
		mysql_query($query);
		header("location:$filename?$id=".$_GET[$id]);
	} 
} else if (isset($_GET['delete'])) {
	if (!isset($_GET[$id]) || $_GET[$id] <= 0) {
		header("location:$filename");
	}
	//check how many versions we have:
	$query = "SELECT lang FROM dtype_v WHERE $id=".$_GET[$id];
	$result = mysql_query($query);
	if (mysql_num_rows($result) <= 1) {
		echo "<SCRIPT LANGUAGE='javascript'>";
		echo "alert('Not allowed to delete last translation of type, do this from the list of types instead');\n";
		echo "document.location='$filname?$id=".$_GET[$id]."';\n";
		echo "</SCRIPT>";
	} else {
		//if user chose to delete language version:
		$query = "DELETE FROM dtype_v WHERE $id=".$_GET[$id]." AND lang=".$_SESSION['lang'];
		mysql_query($query);
		$result = mysql_fetch_row($result);
		$_SESSION['lang'] = $result[0];
		header("location:".$filename."?$id=".$_GET[$id]);
	}
	/* ----------------- if no form is submitted --------------- */
 } else	if (isset($_GET[$id])) {
	$result = mysql_query("SELECT tid, priority, ident FROM dtype WHERE tid=".$_GET['tid']);
	$tmprow = mysql_fetch_assoc($result);
	$mysql = "SELECT dtype.tid, dtype.priority, dtype_v.tname, dtype.ident FROM dtype, dtype_v WHERE dtype.tid=".$_GET['tid']." AND lang='".$_SESSION['lang']."' AND dtype.tid = dtype_v.tid";
	$result = mysql_query($mysql);
	$row = mysql_fetch_assoc($result);
	$row['priority'] = $tmprow['priority'];
	$row['ident'] = $tmprow['ident'];
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta content="text/html; charset=ISO-8859-1" http-equiv="content-type"/>
<LINK REL="stylesheet" type="text/css" href="css/general.css">

<title>Edit/add types</title>
</head>
<body>
<TABLE BORDER=0 WIDTH='100%'><TR><TD><H1>Edit/add Types</H1></TD><TD ALIGN='right'><?php
cms_insert_flags($id, isset($_GET[$id])?$_GET[$id]:null);
?>
</TD></TR></TABLE>
<BR><A HREF='listTypes.php'>Back to list of types</A>
	<HR>
<BR>
	<FORM target="_self" method="get" action="<?php echo $filename; ?>" name="f2">
	<FIELDSET><LEGEND><B>General for all language-versions</B></LEGEND>
	<input type='hidden' name="<?php echo $id; ?>" value="<?php echo  isset($_GET[$id])?$_GET[$id]:""; ?>">
	<TABLE BORDER=0>
	<TR><TH>identifier: </TH><TD><input size="80" name="ident" value="<?php echo isset($row['ident'])?$row['ident']:""; ?>"></TD></TR>
	<TR><TH>priority: </TH><TD><input size="3" name="priority" value="<?php echo isset($row['priority'])?$row['priority']:""; ?>"></TD></TR>
	<?php 
	//first save has to involve language fields as well.. so multisave button isn't shown
	if (isset($_GET[$id])) echo "<TR><TD></TD><TD><INPUT TYPE='submit' value='save' name='multisave'></TD></TR>"; 


	?>
	</TABLE>
	</FIELDSET>
	<BR>
	<FIELDSET><LEGEND><B>Language specific</B></LEGEND>
	<B>name: </B><input size="80" name="tname" value="<?php echo isset($row['tname'])?$row['tname']:""; ?>">
	<INPUT TYPE="submit" value="save" name="singlesave">
	<BR>
	<B>delete language version: </B><INPUT TYPE="submit" value="delete" name="delete">
	</FIELDSET>
	</FORM>
<BR><A HREF='listTypes.php'>Back to list of types</A>
	</body>
	</html>
