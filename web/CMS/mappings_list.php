<?php
require_once("functions/cms_general.php");

/* if we have chosen to remove one */
if (isset($_GET['remove'])) {
	mysql_query("DELETE FROM mapping WHERE mid=".$_GET['remove']);
	header("location:mappings_list.php");
}
?>

<HTML>
<HEAD>
<LINK REL="stylesheet" type="text/css" href="layout/css/general.css">
<SCRIPT LANGUAGE='javascript'>
 function removes(s) {
	if (s.selectedIndex != -1) {
		if (confirm("Do you really want to delete mapping:\n" + s.options[s.selectedIndex].text + "?\n\nthis can NOT be undone")) {
			document.location="mappings_list.php?remove="+s.options[s.selectedIndex].value;
		}
	} else {
		alert("No mapping selected to delete");
	}
}

function edits(s) {
	if (s.selectedIndex != -1) {
		document.location = "mappings_edit.php?mid="+s.options[s.selectedIndex].value;
	} else {
		alert("You have to select a mapping to edit");
	}
}
</SCRIPT>
</HEAD>
<BODY>
<H1>Mappings:</H1>
<HR>
<FORM method="GET" NAME='formlist'>
	<?php echo selectMapping("sel", 25, null); ?>
  <br>
  <br>
<button value="new" name="new" type="button" onCLick="javascript:document.location='mappings_edit.php'">new</button>
<button value="edit" name="edit" type="button" onClick="javascript:edits(document.formlist.sel)">edit</button>
<button value="delete" name="remove" type="button" onClick="javascript:removes(document.formlist.sel)">delete</button>
</FORM>
</BODY>
</HTML>
