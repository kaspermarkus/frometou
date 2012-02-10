<?php
header('Content-Type: text/html; charset=iso-8859-1');

require_once("authorize.php");
require_once("../functions/functions.php");
require_once("../functions/documentBase.php");
require_once("../functions/parsing.php");

$filename = "editDocs.php";
$id = "did";

if (isset($_GET[$id])) {
	$_POST[$id] = $_GET[$id];
 }

//if user chose to delete language version:
if (!isset($_POST[$id]) || $_POST[$id] == "") {
	header("location:listDocs.php");
}
/* -------------------------------- if new language chosen ----------------------------- */
if (isset($_GET['langid'])) {
	$_SESSION['langid'] = $_GET['langid'];
	if (isset($_POST[$id])) {
		$params = "?$id=".$_POST[$id];
	}
	header("location:".$filename.$params);
}

function fix_html_field($arr, $fieldname) {
        $arr[$fieldname] = rmNewlines($arr[$fieldname]);
        $arr[$fieldname] = fixQuotes($arr[$fieldname]);
        $arr[$fieldname] = saveImages($arr[$fieldname]);
}

function gotoAvailableLang() {
	$query = "SELECT langid FROM doc_general_v WHERE did=".$_POST['did'];
	$result = mysql_query($query);
	//if no translations available
	if (mysql_num_rows($result) <= 0) {
		//goto default language
		$query = "SELECT langid FROM defaultLangs";
		$result = mysql_query($query);
	}
	$row = mysql_fetch_assoc($result);
	$_SESSION['langid'] = $row['langid'];
	header("location:".$filename."?did=".$_POST['did']);
}

function save_general_text() {
	global $_POST, $_SESSION, $id;
	//first update the general properties:
	$query = "UPDATE doc SET priority = ".$_POST['priority'].", typeid=".$_POST['typeid'].", ident=\"".$_POST['ident']."\" WHERE $id='".$_POST[$id]."'";
	echo $query;
	mysql_query($query);
	//update translation specific general properties
	$query = "REPLACE doc_general_v ( did, langid, linktext, pagetitle, description ) VALUES ( ".$_POST[$id].", ".$_SESSION['langid'].", \"".$_POST['linktext']."\", \"".$_POST['pagetitle']."\", \"".$_POST['description']."\")"; 
	mysql_query($query);
}

function save_module_text() {
	global $_POST, $_SESSION;
        //take care of generic module text fields
	$sql = "SELECT * FROM module_text WHERE `module_signature` LIKE \"".$_POST['module_signature']."\" ORDER BY priority DESC";
        $result=mysql_query($sql);
        if (mysql_num_rows($result) != null) {
             	while ($row = mysql_fetch_assoc($result)) {
			if ($row['input_type'] == "html") 
				fix_html_field($_POST, $row['signature']);
			print_r($row);
               		$versionsql = "REPLACE module_text_v ( `did` , `text_signature` , `lang_id` , `value`) VALUES ( '".$_POST['did']."', '".$row['signature']."', '".$_SESSION['langid']."', '".$_POST[$row['signature']]."')";
			mysql_query($versionsql);
			echo $versionsql;
            	}	
       }
	
}

function display_prop($arr, $val) {
	return (isset($arr[$val])) ? $arr[$val] : "Undefined";
}

function insert_mandatory_fields() {
	global $prop, $_POST, $id;
	?>
	<TR><TH>identifier: </TH><TD><input TYPE='text' size="50" name="ident" value="<?php echo display_prop($prop, 'ident'); ?>"></TD>
   	    <TH STYLE="width:0; text-align:right;">priority:&nbsp; </TH><TD WIDTH=100%><input TYPE='text' size="3" name="priority" value="<?php echo $prop['priority']; ?>"></TD>
	    <TD WIDTH=0><INPUT TYPE="submit" value="&nbsp;save&nbsp;" name="saveDoc"></TD></TR>

	<TR><TH STYLE="width:0;">type: </TH><TD style="width:0;"> <?php echo selectType("typeid", 1, (isset($_POST[$id])) ? $prop['typeid'] : null); ?></TD>
   	    <TH style="text-align:right; vertical-align:top">image:&nbsp; </TH><TD ROWSPAN=3 STYLE="vertical-align:top; text-align:left;"><A HREF="#" style="font-size:11px;">select image</A></TD>
   	    <TD style="text-align:right"><INPUT TYPE="submit" value="delete" onSubmit="return confirm('Really delete document?');" name="delete"></TD>
	</TR>
	<TR><TH>page title:</TH><TD><input size="50" name="pagetitle" value="<?php echo display_prop($prop, 'pagetitle'); ?>"</TD>
   	    <TD></TD><TD></TD>

	<TR><TH>linktext:</TH><TD><input size="50" name="linktext" value="<?php echo display_prop($prop, 'linktext'); ?>"</TD>
   	    <TD></TD><TD></TD>
	</TR>
	<TR><TH>description: </TH><TD><TEXTAREA COLS=50 ROWS=3 NAME='description'><?php echo display_prop($prop, 'description'); ?></TEXTAREA></TD>
	    <TD></TD><TD></TD>
	</TR>
	<?php
}

function insert_module_fields() {
	global $prop, $_POST, $id;
	//get all fields in the module
	//$sql = "SELECT * FROM module_text_v, module_text WHERE text_signature = signature AND did=".$_POST['did']." AND lang_id=".$_SESSION['langid']." AND module_signature LIKE \"".$prop['module_signature']."\" ORDER BY priority DESC";
	$sql = "SELECT * FROM module_text WHERE `module_signature` LIKE \"".$prop['module_signature']."\" ORDER BY priority DESC";
	//echo $sql;
	$result=mysql_query($sql);
	if (mysql_num_rows($result) != null) {
		//for each field, get the value and print it:
	  	 while ($row = mysql_fetch_assoc($result)) {
			//get value:
			$val_sql = "SELECT value FROM module_text_v WHERE text_signature=\"".$row['signature']."\" AND did=".$_POST['did']." AND lang_id=".$_SESSION['langid'];
			$val_res = mysql_query($val_sql);
			$val_row = null;
			if (mysql_num_rows($val_res) != null) {
				$val_row = mysql_fetch_assoc($val_res);
			}
			//echo $val_sql;
			echo "<TR><TH>".$row['property_name'].":</TH>";
			if ($row['input_type'] == 'text') {
				echo "<TD><input size='50' name=\"".$row['signature']."\" value=\"".display_prop($val_row, 'value')."\" /></TD>";
			} else if ($row['input_type'] == 'html') {
			if (isset($val_row['value'])) {
				$val_row['value'] = fixQuotes($val_row['value']);
				$val_row['value'] = readImages($val_row['value']);
			}
			?>
			<tr><td colspan=4><textarea name="<?php echo $row['signature']; ?>"><?php echo display_prop($val_row, 'value'); ?></textarea>
<script type="txt/javascript" src="ckeditor/ckeditor.js"></script>
			<script language="JavaScript" type="text/javascript">
			CKEDITOR.replace( "<?php echo $row['signature']; ?>" , {toolbar : 'MyToolbar', filebrowserBrowseUrl: "CMS/kfm/"});
			</script></td>
<?php
			}
			echo "</TR>";
		   }
	   	}

}

function delete_general_text() {
	global $_POST, $_SESSION, $id;
	$query = "DELETE FROM doc_general_v WHERE did=".$_POST[$id]." AND langid=".$_SESSION['langid']; 
	mysql_query($query);
}

function delete_module_text() {
	global $_POST, $_SESSION;
        //take care of generic module text fields
        $sql = "DELETE module_text_v FROM module_text, module_text_v WHERE module_signature LIKE  \"".$_POST['module_signature']."\" AND signature LIKE text_signature AND did='".$_POST['did']."' AND lang_id='".$_SESSION['langid']."'";
	echo $sql;
        $result=mysql_query($sql);
} 
/* --------------------------------- document form is submitted ---------------------------------------------------------- */
if (isset($_POST['saveDoc'])) {
	save_general_text();
	save_module_text();
	
	//require_once("modules/".$_POST['module_signature'].".php"); //saveModuleForm();	
	header("location:$filename?$id=".$_POST[$id]);

 } else if (isset($_POST['delete'])) {
	delete_general_text();
	delete_module_text();
	//Handle the rest of the deletion based on the module_signature:
	gotoAvailableLang();









/* -------------- categorization ----------------------------------------------- */
 } else if (isset($_POST['addParent']) && $_POST['addp'] != '-1') {
	$mysql = "INSERT INTO hierarchy (parent, did) VALUES (".$_POST['addp'].", ".$_POST[$id].")";
	mysql_query($mysql);
	header("location:$filename?$id=".$_POST[$id]);
 } else if (isset($_POST['delParent']) && $_POST['delp'] != '-1') {
	mysql_query("DELETE FROM hierarchy WHERE did='".$_POST[$id]."' and parent='".$_POST['delp']."'");
	header("location:$filename?$id=".$_POST[$id]);	
} else if (isset($_POST['addChild']) && $_POST['addc'] != '-1') {
	mysql_query("INSERT INTO hierarchy (parent, did) VALUES (".$_POST[$id].", ".$_POST['addc'].")");
	header("location:$filename?$id=".$_POST[$id]);
 } else if (isset($_POST['delChild']) && $_POST['delc'] != '-1') {
	mysql_query("DELETE FROM hierarchy WHERE did='".$_POST['delc']."' and parent='".$_POST[$id]."'");
	header("location:$filename?$id=".$_POST[$id]);	
/* ----------------- if no form is submitted ------------------------------------ */
 } else	if (isset($_POST[$id])) {
	$query = "SELECT doc.did, doc.module_signature, doc.description_img, doc.priority, doc.typeid, doc.ident, linktext, description, pagetitle ";
	$query .= "FROM doc, doc_general_v WHERE doc.did=".$_POST['did']." AND langid=".$_SESSION['langid']." AND doc.did = doc_general_v.did";
	//echo $query;
	$result = mysql_query($query);
	if (mysql_num_rows($result) > 0) {
		$prop = mysql_fetch_assoc($result);
	//	$prop['body'] = fixQuotes($prop['body']);
	//	$prop['body'] = readImages($prop['body']);
	} else {
		$query = "SELECT did, priority, typeid, module_signature, description_img, ident ";
		$query .= "FROM doc WHERE did=".$_POST['did'];
		$result = mysql_query($query);
		$prop = mysql_fetch_assoc($result);
	}
 }


?>
<HTML>
<HEAD>
<script type="text/javascript" src="functions/jquery.js"></script>	
<script type="text/javascript" src="ckeditor/ckeditor.js"></script>
<SCRIPT LANGUAGE='javascript'>
function showhide(id) {
	if (document.getElementById(id).style.display == 'none') {
		document.getElementById(id).style.display = 'block';
		document.getElementById("documentInfoSubPlus").style.display = "none";
	} else {
		document.getElementById(id).style.display = 'none';
		document.getElementById("documentInfoSubPlus").style.display = "inline-block";
	}
}
</SCRIPT>

<meta http-equiv=Content-Type content="text/html; charset=iso-8859-1" /> 
	<LINK REL="stylesheet" type="text/css" href="css/general.css">
	<title>Edit/add documents</title>
</HEAD>
	<BODY>
	<TABLE BORDER=0 WIDTH='100%'><TR><TD><H1>Edit/add Documents</H1></TD><TD ALIGN='right'><?php
/* -------------- fix flags ------------------------------------ */
$result = mysql_query("SELECT langid, small FROM lang, images WHERE lang.iid = images.iid ORDER BY priority DESC");
while ($r = mysql_fetch_row($result)) {
	if ($r[0] == $_SESSION['langid']) {
		echo "<IMG SRC='".$publicRoot.$r[1]."' WIDTH='44' HEIGHT='30'>&nbsp;";
	} else {
		echo "<A HREF='$filename?";
		if (isset($_POST[$id])) {
			echo "$id=".$_POST[$id]."&";
		}
		echo "langid=".$r[0]."'><IMG SRC='".$publicRoot.$r[1]."' WIDTH='22' HEIGHT='15' BORDER=0></A>&nbsp;";
	}
 }
/* ------------------------------------------------------------ */
?>
</TD></TR></TABLE>


<BR><A HREF='listDocs.php'>Back to list of documents</A>
<HR>
<FORM name="f1" target="_self" method="post" action="<?php echo $filename; ?>" onSubmit="return submitForm();">

<FIELDSET ID="documentInfo"><LEGEND><B>
	<?php
	//Show the basic php stuff
	?>
	<A HREF="#" onClick="showhide('documentInfoSub'); showhide('cke_bodyEdit'); return false;">
		Document properties <font id="documentInfoSubPlus" style="display:none;">+</font>
	</A></B></LEGEND>
	<input type='hidden' name="did" value="<?php echo $_POST['did']; ?>">
	<input type='hidden' name="module_signature" value="<?php echo $prop['module_signature']; ?>">
	<TABLE BORDER=0 id="standardInfo" WIDTH=100%>
	<?php
	//print the mandatory text
	insert_mandatory_fields();
	//insert module text fields
	insert_module_fields();
	
	?>
	<TR><TH COLSPAN=4 style="text-align:left;">
           <INPUT TYPE="submit" value="save" name="saveDoc">
	</TH></TR></table>
	</FIELDSET>
	</form>
	<BR>
		//require_once("modules/".$prop['cms_path'].".php");
		//showCMSModuleForm();	
	
<?php
	if (isset($_POST[$id])) {
       ?>
	   <FIELDSET><LEGEND><B>Categorization</B></LEGEND>
	   <TABLE><TBODY>
	   <TR><TD>
	   <?php 
	   $sql = "SELECT hierarchy.parent, ident FROM hierarchy, doc WHERE ";
       	   $sql .= " doc.did = hierarchy.parent AND hierarchy.did = ".$prop['did'] ;
           $sql .= " ORDER BY ident ASC";
	   //echo $sql;
	   $result=mysql_query($sql);
	   if (mysql_num_rows($result) != null) {
		   while ($row = mysql_fetch_assoc($result)) {
			echo "<A HREF='?did=".$prop['did']."&parent=".$row['parent']."&rmParent=1'>[remove]</A> <A HREF='?did=".$row['parent']."'>".$row['ident']."</A><BR>";
		   }
	   }
	   ?>
	   </TD></TR></TABLE>
	   <FORM METHOD="POST">
	   <?php echo selectDocument("- SELECT PARENT TO ADD -", "addp", 1, null); ?>	<INPUT TYPE="submit" NAME="addParent" VALUE="Set as parent"><BR>
	   <?php echo selectParent(" - SELECT PARENT TO DELETE -", "delp", 1, $_POST[$id]); ?> <INPUT TYPE="submit" NAME="delParent" VALUE="Remove as parent">

	   <?php //if index
		   echo "<HR>";
		   echo selectDocument("- SELECT CHILD TO ADD -", "addc", 1, null);
		   echo "<INPUT TYPE='submit' NAME='addChild' VALUE='Set as child'>";
		   echo "<BR>";
		   echo selectChild("- SELECT CHILD TO REMOVE -", "delc", 1, $_POST[$id]); 
		   echo "<INPUT TYPE='submit' NAME='delChild' VALUE='Remove as child'>";
	   ?>
	   </FORM>
	   </FIELDSET>
	   <?php
	}
?>
<A HREF='listDocs.php'>Back to list of documents</A></BODY>
</HTML>
