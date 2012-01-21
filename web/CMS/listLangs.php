<?php
require_once("authorize.php");
require_once("functions/functions.php");

if (isset($_GET['remove'])) {
	/* check if any documents exists with this language */
	$query = "SELECT did FROM doc_v WHERE langid = '".$_GET['remove']."'";
	$result = mysql_query($query);
	if (mysql_num_rows($result) > 0 && $row = mysql_fetch_row($result)) {
		echo "<SCRIPT LANGUAGE='javascript'>\n";
		echo "alert('A document still exists with translation to this language');\n";
		echo "document.location = 'editDocs.php?did=".$row[0]."&langid=".$_GET['remove']."';";
		echo "</SCRIPT>";
		exit(0);
	}
	/* check if any type exists with this language */
	$query = "SELECT tid FROM dtype_v WHERE langid = '".$_GET['remove']."'";
	$result = mysql_query($query);
	if (mysql_num_rows($result) > 0 && $row = mysql_fetch_row($result)) {
		echo "<SCRIPT LANGUAGE='javascript'>\n";
		echo "alert('A type still exists with translation to this language');\n";
		echo "document.location = 'editTypes.php?tid=".$row[0]."&langid=".$_GET['remove']."';";
		echo "</SCRIPT>";
		exit(0);
	}
	/* check if any image exists with this language */
	$query = "SELECT iid FROM images_v WHERE langid = '".$_GET['remove']."'";
	$result = mysql_query($query);
	if (mysql_num_rows($result) > 0 && $row = mysql_fetch_row($result)) {
		echo "<SCRIPT LANGUAGE='javascript'>\n";
		echo "alert('A image still exists with translation to this language');\n";
		echo "document.location = 'editImgs.php?iid=".$row[0]."&langid=".$_GET['remove']."';";
		echo "</SCRIPT>";
		exit(0);
	}
	/* If no translations to this document exists, delete it */
	$query = "DELETE FROM lang WHERE langid = ".$_GET['remove'];
	mysql_query($query);
	$query = "DELETE FROM defaultlangs WHERE langid = ".$_GET['remove'];
	mysql_query($query);
	header("location:listLangs.php");
 }
?>

<HTML>
<HEAD>
<LINK REL="stylesheet" type="text/css" href="css/general.css">
<SCRIPT LANGUAGE='javascript'>
function remove(s) {
	if (s.selectedIndex != -1) {
		if (confirm("Do you really want to delete language:\n" + s.options[s.selectedIndex].text + "?\n\nthis can NOT be undone")) {
			document.location="listLangs.php?remove="+s.options[s.selectedIndex].value;
		}
	} else {
		alert("No document selected to delete");
	}
}
function edits(s) {
	if (s.selectedIndex != -1) {
		document.location = "editLangs.php?lid="+s.options[s.selectedIndex].value;
	} else {
		alert("You have to select a language to edit");
	}
}
</SCRIPT>
</HEAD>
<BODY>
<H1>Languages:</H1>
<HR>
<FORM method="GET" NAME='formlist'>
	<?php echo selectLanguage("sel", 25, null); ?>
  <br>
  <br>
<button value="new" name="new" type="button" onCLick="javascript:document.location='editLangs.php'">new</button>
<button value="edit" name="edit" type="button" onClick="javascript:edits(document.formlist.sel)">edit</button>
<button value="delete" name="delete" type="button" onClick="javascript:remove(document.formlist.sel)">delete</button>
</FORM>
</BODY>
</HTML>
