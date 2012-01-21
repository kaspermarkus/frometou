<?php
require_once("authorize.php");
require_once("functions/functions.php");

/* if we have chosen to remove one */
if (isset($_GET['remove'])) {
	mysql_query("DELETE FROM file WHERE fid=".$_GET['remove']);
	header("location:listFiles.php");
}
?>

<HTML>
<HEAD>
<LINK REL="stylesheet" type="text/css" href="css/general.css">
<SCRIPT LANGUAGE='javascript'>
 function removes(s) {
	if (s.selectedIndex != -1) {
		if (confirm("Do you really want to delete file:\n" + s.options[s.selectedIndex].text + "?\n\nthis can NOT be undone")) {
			document.location="listFiles.php?remove="+s.options[s.selectedIndex].value;
		}
	} else {
		alert("No file selected to delete");
	}
}
function edits(s) {
	if (s.selectedIndex != -1) {
		document.location = "editFiles.php?fid="+s.options[s.selectedIndex].value;
	} else {
		alert("You have to select a file to edit");
	}
}
</SCRIPT>
</HEAD>
<BODY>
<H1>Files:</H1>
<HR>
<FORM method="GET" NAME='formlist'>
	<?php echo selectFile("sel", 25, null); ?>
  <br>
  <br>
<button value="new" name="new" type="button" onCLick="javascript:document.location='editFiles.php'">new</button>
<button value="edit" name="edit" type="button" onClick="javascript:edits(document.formlist.sel)">edit</button>
<button value="delete" name="remove" type="button" onClick="javascript:removes(document.formlist.sel)">delete</button>
</FORM>
</BODY>
</HTML>
