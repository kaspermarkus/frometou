<?php
require_once("authorize.php");
require_once("../functions/functions.php");
?>

<HTML>
<HEAD>
<LINK REL="stylesheet" type="text/css" href="css/general.css">
<SCRIPT LANGUAGE='javascript'>
function edits(s) {
	if (s.selectedIndex != -1) {
		document.location = "editSpecialText.php?categ="+s.options[s.selectedIndex].value;
	} else {
		alert("You have to select a translation to edit");
	}
}
</SCRIPT>
</HEAD>
<BODY>
<H1>Files:</H1>
<HR>
<FORM method="GET" NAME='formlist'>
	<?php echo selectSpecialText("sel", 25, null); ?>
  <br>
  <br>
<button value="edit" name="edit" type="button" onClick="javascript:edits(document.formlist.sel)">edit</button>
</FORM>
</BODY>
</HTML>
