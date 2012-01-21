<?php
require_once("authorize.php");
require_once("functions/functions.php");

/* if we have chosen to remove one */
if (isset($_GET['remove'])) {
	mysql_query("DELETE FROM defaultlangs WHERE langid=".$_GET['remove']);
	header("location:listDefaultLangs.php");
}

/* if we have chosen to remove one */
if (isset($_GET['add'])) {
	mysql_query("INSERT INTO defaultlangs (langid) VALUES ('".$_GET['add']."')");
	header("location:listDefaultLangs.php");
}
?>

<HTML>
<HEAD>
<LINK REL="stylesheet" type="text/css" href="css/general.css">
<SCRIPT LANGUAGE='javascript'>
 function removes(s) {
	if (s.selectedIndex != -1) {
		if (confirm("Do you really want to remove language:\n" + s.options[s.selectedIndex].text + " as default language?\n\n")) {
			document.location="listDefaultLangs.php?remove="+s.options[s.selectedIndex].value;
		}
	} else {
		alert("No language selected to delete");
	}
}

function adds(s) {
	if (s.selectedIndex != -1) {
		document.location = "listDefaultLangs.php?add="+s.options[s.selectedIndex].value;
	} else {
		alert("You have to select a language to add");
	}
}
</SCRIPT>
</HEAD>
<BODY>
<H1>Default Languages:</H1>
<HR>
<FORM method="GET" NAME='formlist'>
<TABLE>
<TR><TH>Current defaults: </TH><TD><?php echo selectBox("SELECT lang.langid, lang.lname FROM lang, defaultlangs WHERE defaultlangs.langid = lang.langid ORDER BY priority", "remover", 1, null); ?></TD>
	<TD><button value="remove" name="remove" type="button" onCLick="javascript:removes(document.formlist.remover);">remove</button></TD></TR>
<TR><TH>Potential defaults: </TH><TD><?php echo selectBox("SELECT langid, lname FROM lang ORDER BY priority", "adder", 1, null); ?></TD>
	<TD><button value="new" name="new" type="button" onCLick="javascript:adds(document.formlist.adder);">add</button></TD></TR>
</TABLE>
  <br>
</FORM>
</BODY>
</HTML>
