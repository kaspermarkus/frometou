<?php
require_once("functions/cms_general.php");

if (isset($_GET['remove'])) {
	/* check if any documents exists with this language */
	$query = "SELECT did FROM doc WHERE typeid = '".$_GET['remove']."'";
	$result = mysql_query($query);
	if (mysql_num_rows($result) > 0 && $row = mysql_fetch_row($result)) {
		echo "<SCRIPT LANGUAGE='javascript'>\n";
		echo "alert('At least one document still exists with this type...\\n\\nYou will now be redirected');\n";
		echo "document.location = 'editDocs.php?did=".$row[0]."';";
		echo "</SCRIPT>";
		exit(0);
	}
	/* If no document of this type exists */
	$query = "DELETE FROM dtype WHERE tid = ".$_GET['remove'];
	mysql_query($query);
	$query = "DELETE FROM dtype_v WHERE tid = ".$_GET['remove'];
	mysql_query($query);
	header("location:listTypes.php");
 }
?>

<HTML>
<HEAD>
<LINK REL="stylesheet" type="text/css" href="css/general.css">
<SCRIPT LANGUAGE='javascript'>
function remove(s) {
	if (s.selectedIndex != -1) {
		if (confirm("Do you really want to delete type:\n" + s.options[s.selectedIndex].text + "?\n\nthis can NOT be undone")) {
			document.location="listTypes.php?remove="+s.options[s.selectedIndex].value;
		}
	} else {
		alert("No type selected to delete");
	}
}

function edits(s) {
	if (s.selectedIndex != -1) {
		document.location = "editTypes.php?tid="+s.options[s.selectedIndex].value;
	} else {
		alert("You have to select a type to edit");
	}
}
</SCRIPT>
</HEAD>
<BODY>
<H1>Types:</H1>
<HR>
<FORM method="GET" NAME='formlist'>
	<?php echo selectType("sel", 20, null); ?>
  <br>
  <br>
<button value="new" name="new" type="button" onCLick="javascript:document.location='editTypes.php'">new</button>
<button value="edit" name="edit" type="button" onClick="javascript:edits(document.formlist.sel)">edit</button>
<button value="delete" name="delete" type="button" onClick="javascript:remove(document.formlist.sel)">delete</button>
</FORM>
</BODY>
</HTML>
