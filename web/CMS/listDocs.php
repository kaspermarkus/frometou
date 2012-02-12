<?php
require_once("functions/cms_general.php");

/* if user decided to create a new document */
if (isset($_POST['new'])) {
	//find a default type
	$query = "SELECT tid FROM dtype ORDER BY priority DESC";
	$type = mysql_fetch_row(mysql_query($query));
	//create a stub for the new document (the non-language specific)
	$query = "INSERT INTO doc (did, module_signature, typeid, description_img, ident, priority) VALUES ";
	$query .= "( '', '".$_POST['module_signature']."', '".$type[0]."', '', 'new document', '100')";
	//echo $query;
	mysql_query($query);
	//get new id:
	$mysql = "SELECT did FROM doc WHERE module_signature='".$_POST['module_signature']."' AND typeid='".$type[0]."' AND ident='new document' AND priority='100' ORDER BY did DESC LIMIT 1";
	$result = mysql_query($mysql);
	$row = mysql_fetch_row($result); 
	$newID = $row[0];
	//lastly edit the new document in editDoc.php
	header("location:editDocs.php?did=$newID");
}

/* if we have chosen to remove one */
if (isset($_GET['remove'])) {
	if ($_GET['remove'] <= 0) {
		echo "<SCRIPT LANGUAGE='javascript'>\n";
		echo "alert('NOT ALLOWED TO DELETE THIS DOCUMENT');\n";
		echo "document.location='listDocs.php';\n";
		echo "</SCRIPT>";
		exit(0);
	}
	mysql_query("DELETE FROM doc WHERE did=".$_GET['remove']);
	mysql_query("DELETE FROM doc_general_v WHERE did=".$_GET['remove']);
	mysql_query("DELETE FROM doc_module_v WHERE did=".$_GET['remove']);
	mysql_query("DELETE FROM doc_reference_v WHERE did=".$_GET['remove']);
	mysql_query("DELETE FROM hierarchy WHERE did=".$_GET['remove']);
	mysql_query("DELETE FROM hierarchy WHERE parent=".$_GET['remove']);
	header("location:listDocs.php");
}
?>

<HTML>
<HEAD>
<LINK REL="stylesheet" type="text/css" href="css/general.css">
<SCRIPT LANGUAGE='javascript'>
 function removes(s) {
	if (s.selectedIndex != -1) {
		if (confirm("Do you really want to delete the document:\n" + s.options[s.selectedIndex].text + "?\n\nThis means that ALL translations of it, and ALL references to it will be deleted.\n\nThis can NOT be undone!!!")) {
			document.location="listDocs.php?remove="+s.options[s.selectedIndex].value;
		}
	} else {
		alert("No document selected to delete");
	}
}

function edits(s) {
	if (s.selectedIndex != -1) {
		document.location = "editDocs.php?did="+s.options[s.selectedIndex].value;
	} else {
		alert("You have to select a document to edit");
	}
}
</SCRIPT>
</HEAD>
<BODY>
<H1>Documents:</H1>
<HR>
<TABLE BORDER=0 WIDTH=0%>
<TR><TD><FORM method="GET" NAME='formlist'>
	<?php echo selectDocument(null, "sel", "20", null); ?>
  <br>
  <br>
<button value="edit" name="edit" type="button" onClick="javascript:edits(document.formlist.sel)">edit</button>
<button value="delete" name="remove" type="button" onClick="javascript:removes(document.formlist.sel)">delete</button>
</FORM>
<FORM method="POST" NAME="newDoc" ACTION="listDocs.php">
<FIELDSET><LEGEND><B>New Document</B></LEGEND>
<SELECT NAME="module_signature">
<?php 
//show all document modules and prefix with a m_ before name
$query = "SELECT module_signature, module_name FROM module";
$result = mysql_query($query); 
while ($row = mysql_fetch_assoc($result)) {
	echo "<OPTION VALUE=\"".$row['module_signature']."\"'>".$row['module_name']."</OPTION>";
}
?>
</SELECT>
<INPUT TYPE="submit" value="new" name="new">
</FIELDSET>
</FORM>
</TD></TR></TABLE>
<?php echo $query; ?>
</BODY>
</HTML>
