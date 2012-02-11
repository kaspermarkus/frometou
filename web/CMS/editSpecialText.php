<?php
require_once("authorize.php");
require_once("../functions/functions.php");
require_once("../functions/siteInfo.php");

$filename = "editSpecialText.php";
$id = "stid";

if (isset($_GET['langid'])) {
	$_POST['langid'] = $_GET['langid'];
}
if (isset($_GET['categ'])) {
	$_POST['categ'] = $_GET['categ'];
}

/* ------------ if new language chosen ------------ */
if (isset($_POST['langid'])) {
	$_SESSION['langid'] = $_POST['langid'];
	$params = "?categ=".$_POST['categ'];
	header("location:".$filename.$params);
 }

if (isset($_POST['submit'])) {
	/* check if language version already exists: */
	if (mysql_num_rows(mysql_query("SELECT * FROM special_text_v WHERE langid='".$_SESSION['langid']."' AND $id='".$_POST[$id]."'")) > 0) {
		$query = "UPDATE special_text_v SET value = \"".$_POST['value']."\" WHERE $id='".$_POST[$id]."' AND langid='".$_SESSION['langid']."'";
		//echo $query;
		mysql_query($query);
	} else {
		/* translation does not exist, create new translation */
		$query = "INSERT INTO special_text_v ( $id, value, langid) VALUES ( '".$_POST[$id]."', '".$_POST['value']."', '".$_SESSION['langid']."')";
		mysql_query($query);
	}
	header("location:$filename?categ=".$_POST['categ']);
 } else if (isset($_POST['delete'])) {
	/* at lease 1 translation has to exist: */
	 $sql = "SELECT DISTINCT langid FROM special_text_v as stv, special_text as st WHERE category='".$_POST['categ']."' AND st.stid = stv.stid";
	 if (mysql_num_rows(mysql_query($sql)) <= 1) {
		 echo "<SCRIPT LANGUAGE='javascript'>";
		 echo "alert('At least one translation has to exist');\n";
		 echo "document.location='$filename?category=".$_POST['categ']."';\n";
		 echo "</SCRIPT>";
	 } else {
		 /* delete version */
		 $sql = "SELECT stid FROM special_text WHERE category='".$_POST['categ']."'";
		 $r = mysql_query($sql);
		 while ($row = mysql_fetch_row($r)) {
			 mysql_query("DELETE FROM special_text_v WHERE stid='".$row[0]."' AND langid='".$_SESSION['langid']."'");
		 }
		 $res = mysql_query("SELECT langid FROM special_text_v as stv, special_text as st WHERE category='".$_POST['categ']."' AND st.stid=stv.stid");
		 $row = mysql_fetch_row($res);
		 header("location:".$filename."?langid=".$row[0]."&category=".$_POST['categ']);
	 }
} 

if (isset($_POST['categ'])) {
	$query = "SELECT * FROM special_text WHERE category='".$_POST['categ']."' ORDER BY priority DESC";
	$result = mysql_query($query);
	while ($row = mysql_fetch_assoc($result)) {
		$val[$row[$id]]['field'] = $row['field'];
		$ordering[$i++] = $row[$id];
	}
	$query = "SELECT * FROM special_text_v WHERE langid='".$_SESSION['langid']."'";
	$result = mysql_query($query);
	while ($row = mysql_fetch_assoc($result)) {
		if ($val[$row[$id]] != null) {
			$val[$row[$id]]['value'] = $row['value'];
		}
	}
 }
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<SCRIPT LANGUAGE='javascript'>
function del() {
	if (confirm("Really delete this translation? .. this can NOT be undone")) {
		document.location = <?php echo "'$filename?categ=".$_POST['categ']."&delete=true'"; ?>;
	}
}
</SCRIPT>
<meta content="text/html; charset=ISO-8859-1" http-equiv="content-type"/>
<LINK REL="stylesheet" type="text/css" href="css/general.css">
<title>Edit special translations: <?php echo $_POST['categ']; ?></title>
</head>
<body>
	<TABLE BORDER=0 WIDTH='100%'><TR><TD><H1>Edit <?php echo $_POST['categ']; ?></H1></TD><TD ALIGN='right'>
<?php
/* -------------- fix flags ------------------------------------ */
$tmpresult = mysql_query("SELECT langid, small FROM lang, images WHERE lang.iid = images.iid ORDER BY priority DESC");
while ($r = mysql_fetch_row($tmpresult)) {
	if ($r[0] == $_SESSION['langid']) {
		echo "<IMG SRC='".$SITE_INFO_PUBLIC_ROOT.$r[1]."' WIDTH='44' HEIGHT='30'>&nbsp;";
	} else {
		echo "<A HREF='$filename?categ=".$_POST['categ']."&";
		echo "langid=".$r[0]."'><IMG SRC='".$SITE_INFO_PUBLIC_ROOT.$r[1]."' WIDTH='22' HEIGHT='15' BORDER=0></A>&nbsp;";
	}
 }
/* ------------------------------------------------------------ */
?>
</TD></TR></TABLE>
<A HREF='listSpecialText.php'>Back to list of special translations</A>
<HR>
<BR>
<B>Delete translation: </B><INPUT TYPE='BUTTON' VALUE='DELETE' ONCLICK='javascript:del()'><HR>
<TABLE>
<?php
$i = 0;
foreach ($ordering as $index) {
	?>
	<FORM TARGET='_self' METHOD='post' ACTION="<?php echo $filename; ?>" name="f<?php echo $i++; ?>">
		<INPUT TYPE='hidden' NAME='<?php echo $id; ?>' VALUE="<?php echo $index; ?>">
		<INPUT TYPE='hidden' NAME='categ' VALUE="<?php echo $_POST['categ']; ?>">
		<INPUT TYPE='hidden' NAME='field' VALUE="<?php echo $val[$index]['field']; ?>">
		<TR><TH><?php echo $val[$index]['field']; ?>:</TH><TD><TEXTAREA TYPE='text' COLS='70' ROWS='2' NAME='value'><?php echo $val[$index]['value']; ?></TEXTAREA></TD><TD><INPUT TYPE='submit' NAME='submit' VALUE='submit'></TD></TR>
	</FORM>
	<?php
}
?>
</TABLE>
<HR>
<BR><A HREF='listSpecialText.php'>Back to list of special translations</A>
	</body>
	</html>
