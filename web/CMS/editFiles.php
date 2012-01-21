<?php
require_once("authorize.php");
require_once("../functions/documentBase.php");

$filename = "editFiles.php";
$id = "fid";

if (isset($_POST['save'])) {
	//if we have a valid id
	if ($_POST[$id] > 0) {
		if ($_FILES['file']['name'] == null) {
			$query = "UPDATE file SET ident = \"".$_POST['ident']."\" WHERE fid='".$_POST[$id]."'";
			mysql_query($query);
			header("location:$filename?$id=".$_POST[$id]);
		} else {
			$file = $_FILES['file'];
			$ext = substr($file['name'], strpos($file['name'], "."));
			$newname = $relativeFileDir.time().$ext;
			if (move_uploaded_file($file['tmp_name'], $localRoot.$newname)) {
				$query = "UPDATE file SET path = \"$newname\", ident = \"".$_POST['ident']."\" WHERE fid='".$_POST[$id]."'";
				mysql_query($query);
				echo "<SCRIPT LANGUAGE='javascript'>";
				echo "alert('File successfully uploaded/updated');\n";
				echo "document.location = '$filename?$id=".$_POST[$id]."';";
				echo "</SCRIPT>";
			} else {
				echo 'An error orccured when trying to upload file! Upload aborted.<br>';
				echo "<a href='?$id=".$_POST[$id]."'>please try again</a>";
			}
		}				
	} else {
		$file = $_FILES['file'];
		$ext = substr($file['name'], strpos($file['name'], "."));
		$newname = $relativeFileDir.time().$ext;
		if(move_uploaded_file($file['tmp_name'], $localRoot.$newname)) {
			$query = "INSERT INTO file ( path, ident ) VALUES (\"$newname\", \"".$_POST['ident']."\")";
			mysql_query($query);
			$query = "SELECT fid FROM file ORDER BY fid DESC";
			$row = mysql_fetch_row(mysql_query($query));
			echo "<SCRIPT LANGUAGE='javascript'>";
			echo "alert('File successfully uploaded');\n";
			echo "document.location = '$filename?$id=".$row[0]."';";
			echo "</SCRIPT>";
		} else {
			echo 'An error orccured when trying to upload file! Upload aborted.<br>';
			echo '<a href="">please try again</a>';
		}
	}
 } else	if (isset($_GET[$id])) {
	$result = mysql_query("SELECT * FROM file WHERE $id=".$_GET[$id]);;
	$row = mysql_fetch_assoc($result);
 }
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta content="text/html; charset=ISO-8859-1" http-equiv="content-type"/>
	<LINK REL="stylesheet" type="text/css" href="css/general.css">
	<title>Edit/add files</title>
	</head>
	<body>
	<H1>Edit/add files</H1>
<A HREF='listFiles.php'>Back to list of files</A>
	<HR>
	<BR>
	<FORM target="_self"  enctype="multipart/form-data" method="POST" action="<?php echo $filename; ?>" name="f1">
	<FIELDSET><LEGEND><B>Properties</B></LEGEND>
	<input type='hidden' name="<?php echo $id; ?>" value="<?php echo $_GET[$id]; ?>">
	<TABLE>
	<?php if ($row['path'] != "") echo "<TR><TH>current file: </TH><TD><A HREF='".$publicRoot.$row['path']."' TARGET='_blank'>open in new window</A></TD></TR>"; ?>
	<TR><TH>path: </TH><TD><input size="80" name="file" type='file' value="<?php echo $row['path']; ?>"></TD></TR>
	<TR><TH>ident: </TH><TD><input size="80" name="ident" type='text' value="<?php echo $row['ident'] ?>"></TD></TR>
	</TABLE>
	<INPUT TYPE="submit" value="save" name="save">
	</FIELDSET>
	</FORM>
<BR><A HREF='listFiles.php'>Back to list of files</A>
	</body>
	</html>
