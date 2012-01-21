<?php
require_once("authorize.php");
require_once("functions/functions.php");

/* if we have chosen to remove one */
if ($_GET['remove'] > 0) {
	mysql_query("DELETE FROM images WHERE iid=".$_GET['remove']);
	mysql_query("DELETE FROM images_v WHERE iid=".$_GET['remove']);
	header("location:listImgs.php");
}
?>

<HTML>
<HEAD>
<LINK REL="stylesheet" type="text/css" href="css/general.css">
<SCRIPT LANGUAGE='javascript'>
 function removes(s) {
	if (s.selectedIndex != -1) {
		if (confirm("Do you really want to delete image:\n" + s.options[s.selectedIndex].text + "?\n\nthis can NOT be undone")) {
			document.location="listImgs.php?remove="+s.options[s.selectedIndex].value;
		}
	} else {
		alert("No image selected to delete");
	}
}

function edits(s) {
	if (s.selectedIndex != -1) {
		document.location = "editImgs.php?iid="+s.options[s.selectedIndex].value;
	} else {
		alert("You have to select a image to edit");
	}
}
</SCRIPT>
</HEAD>
<BODY>
<H1>Images:</H1>
<HR>
<FORM method="GET" NAME='formlist'>
	<?php echo selectImage("sel", 25, null); ?>
  <br>
  <br>
<button value="new" name="new" type="button" onCLick="javascript:document.location='editImgs.php'">new</button>
<button value="edit" name="edit" type="button" onClick="javascript:edits(document.formlist.sel)">edit</button>
<button value="delete" name="remove" type="button" onClick="javascript:removes(document.formlist.sel)">delete</button>
</FORM>
</BODY>
</HTML>
