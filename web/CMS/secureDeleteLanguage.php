<?php
require_once("authorize.php");
require_once("functions/functions.php");

/* if we have chosen to remove one */
if (isset($_GET['remove'])) {
	mysql_query("DELETE FROM images_v WHERE lang=".$_GET['remove']);
	mysql_query("DELETE FROM type_v WHERE lang=".$_GET['remove']);
	mysql_query("DELETE FROM doc_v WHERE lang=".$_GET['remove']);
	/* check if this is the last version of a document */
	header("location:listDocs.php");
}
?>

<HTML>
<HEAD>
<LINK REL="stylesheet" type="text/css" href="css/general.css">
<SCRIPT LANGUAGE='javascript'>
 function removes(s) {
	if (s.selectedIndex != -1) {
		if (confirm("Do you really want to delete language:\n" + s.options[s.selectedIndex].text + "?, this means that ALL translations to this language also will be deleted.\n\nthis can NOT be undone")) {
			document.location="secureDeleteLanguage.php?remove="+s.options[s.selectedIndex].value;
		}
	} else {
		alert("No language selected to delete");
	}
}
</SCRIPT>
</HEAD>
<BODY>
<H1>Language deletion:</H1>
<HR>
Deleting languages from this list, means that ALL translations to this language (of documents, image-text etc) will be DELETED .. this action can not be undone.
<HR>
<HR>
<FORM method="GET" NAME='formlist'>
	<?php echo SelectLanguage("lidselect", 20, $_GET["lidselect"]); ?>
  <br>
  <br>
<button value="delete" name="remove" type="button" onClick="javascript:removes(document.formlist.lidselect)">delete</button>
</FORM>
</BODY>
</HTML>
