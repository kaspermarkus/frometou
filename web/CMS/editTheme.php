<?php
require_once("functions/cms_general.php");
require_once("functions/templateHandling.php");

//If the form was submitted:
if (isset($_POST['submitSelectTemplate'])) {
	$newTemplate = $_POST['templateSelecter'];
	//copy values user hasn't got in his layout
	safe_copy_template_entries($_POST["layout_used"]);
	//set new layout
	mysql_query("UPDATE layout SET layout_used='$newTemplate' WHERE TRUE");
} else if (isset($_POST['resetTemplate'])) {
	//clear user settings
	delete_template_entries();
	//set copy layout values to user:
	safe_copy_template_entries($_POST["layout_used"]);
}

$query = "SELECT layout_used FROM layout";
$result = mysql_query($query);
$result = mysql_fetch_assoc($result);
$layout_used = $result["layout_used"];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta content="text/html; charset=ISO-8859-1" http-equiv="content-type"/>
	<LINK REL="stylesheet" type="text/css" href="css/general.css">
	<title>Theme Templates</title>
	</head>
	<body>
	<H1>Theme Templates</H1>
	<HR>
	<BR>
	<FIELDSET><LEGEND><B>Theme selection</B></LEGEND>
	<TABLE>
	<TR><TH>
	    <FORM target="_self"  enctype="multipart/form-data" method="POST" onSubmit="return confirm('Do you really want to change the template?')" action="editTheme.php" name="templateForm">
	       <INPUT TYPE='hidden' NAME='layout_used' VALUE="<?php echo $layout_used; ?>">
	       Select Template: </TH><TD><?php echo selectLayoutTemplate("templateSelecter", "1", "$layout_used"); ?></TD>
		<TD><INPUT TYPE="submit" value="apply" name="submitSelectTemplate"></TD>
	    </FORM>
	</TR>
	<TR><TH>
	    <FORM target="_self"  enctype="multipart/form-data" method="POST" onSubmit="return confirm('Do you really want to reset user changes to layout?\n\n This means that all the changes you have made to the layout will be reset to the template selected (the changes in actual content, like documents, will of course not be changed')" action="editTheme.php" name="resetTemplateForm">
	       <INPUT TYPE='hidden' NAME='layout_used' VALUE="<?php echo $layout_used; ?>">
	Reset User Changes: </TH><TD><INPUT TYPE="submit" value="Reset" name="resetTemplate"></TD><TD></TD></TR>
	
	</TABLE>
	</FIELDSET>
	</FORM>
	</body>
	</html>
