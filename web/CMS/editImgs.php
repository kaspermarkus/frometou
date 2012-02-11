<?php
require_once("authorize.php");
require_once("../functions/functions.php");
require_once("../functions/siteInfo.php");
$filename = "editImgs.php";
$id = "iid";
if (!isset($_POST[$id])) {
	$_POST[$id] = $_GET[$id];
 }

/* -------------------------------- if new language chosen ----------------------------- */
if (isset($_GET['langid'])) {
	$_SESSION['langid'] = $_GET['langid'];
	if (isset($_GET[$id])) {
		$params = "?$id=".$_GET[$id];
	}
	header("location:".$filename.$params);
 }

/* --------------------------------- if form is submitted ------------------------------ */
if (isset($_POST['singlesave'])) {
	//if the id and the language version exists------------------
	if ($_POST[$id] > 0 && mysql_num_rows(mysql_query("SELECT * FROM images_v WHERE $id=".$_POST[$id]." AND langid=".$_SESSION['langid'])) > 0) {
		$query = "UPDATE images_v SET ";
		$query .= "$id=".$_POST[$id].", langid=".$_SESSION['langid'].", alt=\"".$_POST['alt']."\" ";
		$query .= " WHERE $id = ".$_POST[$id];
		$query .= " AND langid = ".$_SESSION['langid'];
		mysql_query($query);
		header("location:$filename?$id=".$_POST[$id]);
	//if the id exist, but no language version exist-------------
	} else if ($_POST[$id] != "") { 
		$query = "INSERT INTO images_v ($id, langid, alt) VALUES ";
		$query .= "( ".$_POST[$id].", ".$_SESSION['langid'].", \"".$_POST['alt']."\" )";
		mysql_query($query);
		header("location:$filename?$id=".$_POST[$id]);
	}
/* --------------------- multisave --------------------------------------------- */
 } else if (isset($_POST['multisave'])) {
	//if no we have a valid id
	if ($_POST[$id] != "") {
		if ($_POST[$id] != "-1") {
			$extras = "";
			if ($_FILES['small']['name'] != null) {
				$small = $_FILES['small'];
				$small_ext = substr($small['name'], strpos($small['name'], "."));
				$smallname = $relativeImageDir."s_".time().$small_ext;
				$extras .= ", small=\"$smallname\"";
				if (!move_uploaded_file($small['tmp_name'], $SITE_INFO_LOCALROOT.$smallname)) {
					echo 'An error orccured when trying to upload Images! Upload aborted.<br>';
					echo "<a href='?$id=".$_POST[$id]."'>please try again</a>";
					exit(0);
				}
			}
			if ($_FILES['big']['name'] != null) {
				$big = $_FILES['big'];
				$big_ext = substr($big['name'], strpos($big['name'], "."));
				$bigname = $relativeImageDir.time().$big_ext;
				$extras .= ", big=\"$bigname\"";
				if (!move_uploaded_file($big['tmp_name'], $SITE_INFO_LOCALROOT.$bigname)) {
					echo 'An error orccured when trying to upload Images! Upload aborted.<br>';
					echo "<a href='?$id=".$_POST[$id]."'>please try again</a>";
					exit(0);
				}
			}
			echo "EXTRAS: $extras<BR>";
			$query = "UPDATE images SET ident=\"".$_POST['ident']."\"";
			$query .= $extras;
			$query .= " WHERE $id=".$_POST[$id];
			echo "query: $query<BR>";
			mysql_query($query);
			echo "<SCRIPT LANGUAGE='javascript'>";
			echo "alert('Images successfully uploaded/updated');\n";
			echo "document.location = '$filename?$id=".$_POST[$id]."';";
			echo "</SCRIPT>";
		} else {
			header("location:$filename?$id=-1");
		}
	} else {
		if ($_FILES['small'] == null && $_FILES['big'] == null) {
			echo "<SCRIPT LANGUAGE='javascript'>";
			echo "alert('you have to upload at least one image')";
			echo "</SCRIPT>";
		}
		if ($_FILES['small']['name'] != null) {
			$small = $_FILES['small'];
			$small_ext = substr($small['name'], strpos($small['name'], "."));
			$smallname = $relativeImageDir."s_".time().$small_ext;
			if (!move_uploaded_file($small['tmp_name'], $SITE_INFO_LOCALROOT.$smallname)) {
				echo 'An error orccured when trying to upload small image! Upload aborted.<br>';
				echo "<a href='?$id=".$_POST[$id]."'>please try again</a>";
			}
		}
		if ($_FILES['big']['name'] != null) {
			$big = $_FILES['big'];
			$big_ext = substr($big['name'], strpos($big['name'], "."));
			$bigname = $relativeImageDir.time().$big_ext;
			if (!move_uploaded_file($big['tmp_name'], $SITE_INFO_LOCALROOT.$bigname)) {
				echo 'An error orccured when trying to upload big Image! Upload aborted.<br>';
				echo "<a href='?$id=".$_POST[$id]."'>please try again</a>";
			}
		}
		$query = "INSERT INTO images (small, big, ident ) VALUES (\"$smallname\", \"$bigname\", \"".$_POST['ident']."\")";
		mysql_query($query);
		echo "<SCRIPT LANGUAGE='javascript'>";
		echo "alert('Images successfully uploaded/updated');\n";
		$row = mysql_fetch_row(mysql_query("SELECT iid FROM images ORDER BY iid DESC"));
		echo "document.location = '$filename?$id=".$row[0]."';";
		echo "</SCRIPT>";
	}
/* ---------------- if user selected delete ---------------------------------------- */
 } else if (isset($_POST['delete'])) {
	if (!isset($_POST[$id])) {
		header("location:$filename");
	}
	//if user chose to delete language version:
	$query = "DELETE FROM images_v WHERE $id=".$_POST[$id]." AND langid=".$_SESSION['langid'];
	mysql_query($query);
	$query = "SELECT langid FROM images_v WHERE $id=".$_POST[$id];
	$result = mysql_query($query);
	if (mysql_num_rows($result) > 0) { //if we didn't delete every language version of this document, goto a valid one
		$result = mysql_fetch_row($result);
		$_SESSION['langid'] = $result[0];
	}
	header("location:".$filename."?$id=".$_POST[$id]);
 /* ----------------- if no form is submitted ------------------------------------ */
 } else	if (isset($_GET[$id])) {
	$query = "SELECT iid, small, big, ident FROM images WHERE $id='".$_GET[$id]."'";
	$row = mysql_fetch_assoc(mysql_query($query));

	$query = "SELECT images_v.iid, images_v.alt ";
	$query .= "FROM images, images_v WHERE images.iid=".$_GET['iid']." AND langid=".$_SESSION['langid']." AND images.iid = images_v.iid";	
	$result = mysql_query($query);
	$row_v = mysql_fetch_assoc($result);
 }
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta content="text/html; charset=ISO-8859-1" http-equiv="content-type"/>
	<LINK REL="stylesheet" type="text/css" href="css/general.css">
	<title>Edit/add images</title>
	</head>
	<body>
	<TABLE BORDER=0 WIDTH='100%'><TR><TD><H1>Edit/add images</H1></TD><TD ALIGN='right'><?php
/* -------------- fix flags ------------------------------------ */
$result = mysql_query("SELECT langid, small FROM lang, images WHERE lang.iid = images.iid ORDER BY priority DESC");
while ($r = mysql_fetch_row($result)) {
	if ($r[0] == $_SESSION['langid']) {
		echo "<IMG SRC='".$SITE_INFO_PUBLIC_ROOT.$r[1]."' WIDTH='44' HEIGHT='30'>&nbsp;";
	} else {
		echo "<A HREF='$filename?";
		if (isset($_GET[$id])) {
			echo "$id=".$_GET[$id]."&";
		}
		echo "langid=".$r[0]."'><IMG SRC='".$SITE_INFO_PUBLIC_ROOT.$r[1]."' WIDTH='22' HEIGHT='15' BORDER=0></A>&nbsp;";
	}
 }
/* ------------------------------------------------------------ */
?> 
</TD></TR></TABLE>
<BR><A HREF='listImgs.php'>Back to list of images</A>
	<HR>
<BR>
	<FORM target="_self" enctype="multipart/form-data" method="post" action="<?php echo $filename; ?>" name="f1">
	<input type='hidden' name='<?php echo $id; ?>' value="<?php echo $_GET[$id]; ?>">
	<FIELDSET><LEGEND><B>General for all translations</B></LEGEND>
	<TABLE BORDER=0><TR>
	<?php 
	echo "<TR><TH>current small: </TH><TD>";
if ($row['small'] != "") 
	echo "<A HREF='".$SITE_INFO_PUBLIC_ROOT.$row['small']."' TARGET='_blank'><IMG SRC='".$SITE_INFO_PUBLIC_ROOT.$row['small']."' BORDER=0 WIDTH=50 HEIGHT=50></A>";
 else 
	 echo "NONE";
echo "</TD></TR>"; 
?>
	<TH>small: </TH><TD><input size="80" name="small" type='file'></TD></TR>
	<?php 
	echo "<TR><TH>current big: </TH><TD>";
if ($row['big'] != "") 
	echo "<A HREF='".$SITE_INFO_PUBLIC_ROOT.$row['big']."' TARGET='_blank'><IMG SRC='".$SITE_INFO_PUBLIC_ROOT.$row['big']."' BORDER=0 WIDTH=50 HEIGHT=50></A>";
 else 
	 echo "NONE";
echo "</TD></TR>"; 
?>
	<TH>big: </TH><TD><input size="80" name="big" type='file'></TD></TR>
	<TH>identifier: </TH><TD><input size="80" name="ident" value="<?php echo $row['ident']; ?>"></TD></TR>
	</TABLE>
	<INPUT TYPE="submit" value="save" name="multisave">
	</FIELDSET>
	<BR>
<?php 
	if (isset($_GET[$id])) {?>
		<FIELDSET><LEGEND><B>Translation</B></LEGEND>
		<B>alternative text: </B><input size="80" name="alt" value="<?php echo $row_v['alt'] ?>">
		<INPUT TYPE="submit" value="save" name="singlesave">
		<BR>
		<HR>
		<B>delete language version: </B><INPUT TYPE="submit" value="delete" name="delete">
		</FIELDSET>
<?php	}
?>
</FORM>
<BR><A HREF='listImgs.php'>Back to list of images</A>
</body>
</html>
