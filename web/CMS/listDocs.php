<?php
require_once("authorize.php");
require_once("../functions/functions.php");

/* if user decided to create a new document */
if (isset($_POST['new'])) {
	//if it is a document module (starts with m_)
	/*if (preg_match("/^m_([0-9]+)/", $_POST['module_signature'], $mid_match)) {
		$mid = $mid_match[1];
		$_POST['module_signature'] = "module";
	}*/
	/* get random type */
	$type = mysql_fetch_row(mysql_query("SELECT tid FROM dtype ORDER BY priority DESC"));
	//echo "SELECT tid FROM dtype ORDER BY priority DESC";
	$query = "INSERT INTO doc (did, module_signature, typeid, description_img, ident, priority) VALUES ";
	$query .= "( '', '".$_POST['module_signature']."', '".$type[0]."', '', 'new document', '100')";
	//echo $query;
	mysql_query($query);
	//get new id:
	$result = mysql_query("SELECT did FROM doc WHERE module_signature='".$_POST['module_signature']."' AND typeid='".$type[0]."' AND ident='new document' AND priority='100' ORDER BY did DESC LIMIT 1");
	//echo "SELECT did FROM doc WHERE module_signature='".$_POST['module_signature']."' AND typeid='".$type[0]."' AND ident='new document' AND priority='100' ORDER BY did DESC LIMIT 1";
	$row = mysql_fetch_row($result); 
	$newID = $row[0];
	//echo "new id: $newID;";
	//if the document is a module, copy all the default properties
	/*if (isset($mid)) {
		//check if we have a version in the current language
	//	echo $_SESSION['langid'];	
		$query = "SELECT p.prop_id, value FROM doc_module_v as m_v, doc_module_property as p WHERE p.prop_id=m_v.prop_id AND m_v.did=-1 AND p.module_id=$mid AND m_v.lang_id=".$_SESSION['langid'];
	//	echo $query;
		$result = mysql_query($query);
		if (mysql_num_rows($result) <= 0) {
			//no default values in the current language, copy from the first found language instead
			$query="SELECT m_v.lang_id FROM doc_module_v as m_v, doc_module_property as p WHERE p.prop_id=m_v.prop_id AND m_v.did=-1 AND p.module_id=$mid LIMIT 1";
			$row = mysql_fetch_row(mysql_query($query));
			$lang = $row[0];
			$query = "SELECT p.prop_id, value FROM doc_module_v as m_v, doc_module_property as p WHERE p.prop_id=m_v.prop_id AND m_v.did=-1 AND p.module_id=$mid AND m_v.lang_id=".$lang;
			$result=mysql_query($query);
		}
		//copy the actual module data:
		while ($row = mysql_fetch_assoc($result)) {
			$query="INSERT INTO doc_module_v ( did, prop_id, lang_id, value ) VALUES ( $newID, ".$row['prop_id'].", ".$_SESSION['langid'].", \"".$row['value']."\")";
	//		echo $query."<BR>";
			mysql_query($query);
		}
	}*/
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
	mysql_query("DELETE FROM doc_regular_v WHERE did=".$_GET['remove']);
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
<OPTION VALUE="regular">Normal document</OPTION>
<OPTION VALUE="reference">Reference</OPTION>
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
