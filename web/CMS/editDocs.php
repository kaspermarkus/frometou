<?php
header('Content-Type: text/html; charset=iso-8859-1');

require_once("functions/cms_general.php");
require_once("functions/parsing.php");

$filename = "editDocs.php";
print_r( $_POST );
class dataContainer {
	var $data = [];
	function add($category, $query) {
		// echo $query;
		$result = mysql_query($query);
		if ($result && mysql_num_rows($result) > 0) {
			$this->data[$category] = mysql_fetch_assoc($result);
			// print_r($this->data);
			return true;
		}
		return false;
	}

	function get($category, $key) {
		return ($this->data[$category]) ? $this->data[$category][$key] : NULL;
	}

	function init($did) {
		if (!isset($did)) {
			echo $did;
			die();
			header("location:listDocs.php");
		}
		$this->add("baseData", "SELECT doc.module_signature, doc.did, module_name, cms_path, typeid, description_img ".
			"FROM doc, module ".
			"WHERE doc.module_signature = module.module_signature AND doc.did=".$did);
 		//load module:
		require_once($this->get("baseData", "cms_path"));
		$this->data['modules'][$this->get("baseData", "module_signature")] = newModule();
	}

	function loadTranslation($lang) {
		$query = "SELECT linktext, description, pagetitle ";
		$query .= "FROM doc_general_v WHERE did=".$this->get("baseData", 'did')." AND langid='".$lang."'";
		$this->add("baseData_v", $query);
		$this["baseData"]["lang"] = $lang;
		foreach($this->data['modules'] as $n=>$o) {
			$o->init($this->get("baseData", 'did'), $lang);
		}		
	}

	function save($post, $lang) {
		//first update the general properties:
		$query = "UPDATE doc SET priority = ".$post['priority'].", typeid=".$post['typeid'].", ident=\"".$post['ident']."\", description_img=\"".$post['description_img']."\" WHERE id='".$this->get("baseData", "did")."'";
		echo $query;
		mysql_query($query);
		//update translation specific general properties
		$query = "REPLACE doc_general_v ( did, langid, linktext, pagetitle, description ) VALUES ( ".$post['did'].", ".$lang.", \"".$post['linktext']."\", \"".$post['pagetitle']."\", \"".$post['description']."\")"; 
		echo $query."<br />";		
		mysql_query($query);
		foreach($this->data['modules'] as $n=>$o) {
			$o->save($post, $lang);
		}
	}
}


//load basic document properties into $data
$data = new dataContainer;
$data->init((isset($_GET['did'])) ? $_GET['did'] : $data->get("baseData", 'did'));
print_r($data);

//if new language chosen
if (isset($_GET['lang'])) {
	$_SESSION['lang'] = $_GET['lang'];
}

//save if user has clicked saved
if (isset($_POST['saveDoc'])) {
	$data->save($_POST, $_SESSION['lang']);
	// // save_general_text($_POST);
	// //save_module_props($_POST);
	// die();
	// //require_once("modules/".$_POST['module_signature'].".php"); //saveModuleForm();	
	// header("location:$filename?$id=".$_POST[did]);
}

// function save_general_text() {
// 	global $_POST, $_SESSION, $id;
// 	//first update the general properties:
// 	$query = "UPDATE doc SET priority = ".$_POST['priority'].", typeid=".$_POST['typeid'].", ident=\"".$_POST['ident']."\", description_img=\"".$_POST['description_img']."\" WHERE $id='".$data->get('did')."'";
// 	echo $query;
// 	mysql_query($query);
// 	//update translation specific general properties
// 	$query = "REPLACE doc_general_v ( did, langid, linktext, pagetitle, description ) VALUES ( ".$data->get("baseData", 'did').", ".$_SESSION['lang'].", \"".$_POST['linktext']."\", \"".$_POST['pagetitle']."\", \"".$_POST['description']."\")"; 
// 	mysql_query($query);
// 	echo $query;
// 	// die();
// }

// function save_module_props() {
// 	global $_POST, $_SESSION;
//         //take care of generic module text fields
// 	$sql = "SELECT * FROM module_props WHERE `module_signature` LIKE \"".$_POST['module_signature']."\" ORDER BY priority DESC";
//         $result=mysql_query($sql);
//         if (mysql_num_rows($result) != null) {
//              	while ($row = mysql_fetch_assoc($result)) {
// 			if ($row['input_type'] == "html") 
// 				fix_html_field($_POST, $row['signature']);
// 			//print_r($row);
//                		$versionsql = "REPLACE doc_module_v ( `did` , `prop_signature` , `langid` , `value`) VALUES ( '".$data->get("baseData", 'did')."', '".$row['signature']."', '".$_SESSION['lang']."', '".$_POST[$row['signature']]."')";
// 			mysql_query($versionsql);
// 			//echo $versionsql;
//             	}	
//        }
	
// }

function display_prop($arr, $val) {
	return (isset($arr[$val])) ? $arr[$val] : "";
}

function insert_mandatory_fields() {
	global $prop, $_POST, $SITE_INFO_PUBLIC_ROOT, $data;
	?>
	<TR><TH>identifier: </TH><TD><input TYPE='text' size="50" name="ident" value="<?php echo display_prop($prop, 'ident'); ?>"></TD>
   	    <TH STYLE="width:0; text-align:right;">priority:&nbsp; </TH><TD WIDTH=100%><input TYPE='text' size="3" name="priority" value="<?php echo $prop['priority']; ?>"></TD>
	    <TD WIDTH=0><INPUT TYPE="submit" value="&nbsp;save&nbsp;" name="saveDoc"></TD></TR>

	<TR><TH STYLE="width:0;">type: </TH><TD style="width:0;"> <?php echo selectType("typeid", 1, ($data->get("baseData", 'did') != NULL) ? $prop['typeid'] : null); ?></TD>
   	    <TH style="text-align:right; vertical-align:top">image:&nbsp; </TH><TD ROWSPAN=3 STYLE="vertical-align:top; text-align:left;">
			<?php
?>
	<script language='javascript'>
	function update_description_img() {
		window.SetUrl=(function(id){
               		 return function(value){
                                document.getElementById('description_img').src = value;
				var public_root = <?php echo "/".str_replace("/", '\/', $SITE_INFO_PUBLIC_ROOT)."/"; ?>;
				value=value.replace(public_root, '');
                                document.getElementById('description_img_form_field').value = value;
                         }
                })(this.id);
                var kfm_url='kfm/';
                window.open(kfm_url,'kfm','modal,width=600,height=400');
	
	}
	//kfm_init();
	</script>
	 <input type='hidden' NAME='description_img'  id="description_img_form_field" VALUE="<?php echo $prop['description_img']; ?>" name='description_img'>
	<A HREF="#" class="kfm" onClick="javascript:update_description_img()"><IMG WIDTH='150px' SRC="<?php echo $SITE_INFO_PUBLIC_ROOT.(($prop['description_img'])?$prop['description_img']:'imgs/no_img.svg'); ?>" id="description_img" /> </A></TD>
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
	global $prop, $data;
	//get module info
	$sql = "SELECT * FROM module_props WHERE `module_signature` LIKE \"".$prop['module_signature']."\" ORDER BY priority DESC";
	//echo $sql;
	$result=mysql_query($sql);
	//require and initialize
	// require_once($data->get("module", "cms_path"));
	$module = $data->get('modules', $prop['module_signature']);
	// print_r($module);
	$module->init($data->get("baseData", 'did'), $_SESSION['lang']);
	//print form
	$module->printHTMLForm();
}

function delete_general_text() {
	global $_POST, $_SESSION;
	$query = "DELETE FROM doc_general_v WHERE did=".$_POST[did]." AND langid=".$_SESSION['lang']; 
	mysql_query($query);
}

function delete_module_props() {
	global $_POST, $_SESSION;
        //take care of generic module text fields
        $sql = "DELETE doc_module_v FROM module_props, doc_module_v WHERE module_signature LIKE  \"".$_POST['module_signature']."\" AND signature LIKE prop_signature AND did='".$data->get("baseData", 'did')."' AND langid='".$_SESSION['lang']."'";
	echo $sql;
        $result=mysql_query($sql);
} 

if (isset($_POST['delete'])) {
	delete_general_text();
	delete_module_props();
	//Handle the rest of the deletion based on the module_signature:
	gotoAvailableLang();




/* -------------- categorization ----------------------------------------------- */
 } else if (isset($_POST['addParent']) && $_POST['addp'] != '-1') {
	$mysql = "INSERT INTO hierarchy (parent, did) VALUES (".$_POST['addp'].", ".$data->get("baseData", 'did').")";
	mysql_query($mysql);
	header("location:$filename?did=".$data->get("baseData", 'did'));
 } else if (isset($_POST['delParent']) && $_POST['delp'] != '-1') {
	mysql_query("DELETE FROM hierarchy WHERE did='".$data->get("baseData", 'did')."' and parent='".$_POST['delp']."'");
	header("location:$filename?did=".$data->get("baseData", 'did'));	
} else if (isset($_POST['addChild']) && $_POST['addc'] != '-1') {
	mysql_query("INSERT INTO hierarchy (parent, did) VALUES (".$data->get("baseData", 'did').", ".$_POST['addc'].")");
	header("location:$filename?did=".$data->get("baseData", 'did'));
 } else if (isset($_POST['delChild']) && $_POST['delc'] != '-1') {
	mysql_query("DELETE FROM hierarchy WHERE did='".$_POST['delc']."' and parent='".$data->get("baseData", 'did')."'");
	header("location:$filename?did=".$data->get("baseData", 'did'));	






/* ----------------- if no form is submitted ------------------------------------ */
 } else	if ($data->get("baseData", 'did') != NULL) {
 	// $data->add("module", "SELECT cms_path, module_name FROM module, doc WHERE doc.did=".$data->get("baseData", 'did')." AND doc.module_signature=module.module_signature");
 	// print_r($data->data);

	$query = "SELECT doc.did, doc.module_signature, doc.description_img, doc.priority, doc.typeid, doc.ident, linktext, description, pagetitle ";
	$query .= "FROM doc, doc_general_v WHERE doc.did=".$data->get("baseData", 'did')." AND langid='".$_SESSION['lang']."' AND doc.did = doc_general_v.did";
	//echo $query;
	$result = mysql_query($query);
	if (mysql_num_rows($result) > 0) {
		$prop = mysql_fetch_assoc($result);
	} else {
		$query = "SELECT doc.did, module.cms_path, doc.priority, doc.typeid, doc.module_signature, doc.description_img, doc.ident".
		" FROM doc, module WHERE doc.did = ".$data->get("baseData", 'did').
		" AND doc.module_signature = module.module_signature";
		// SELECT did, priority, typeid, module_signature, description_img, ident ";
		// $query .= "FROM doc WHERE did=".$data->get('did');
		$result = mysql_query($query);
		$prop = mysql_fetch_assoc($result);
	}
 }


?>
<HTML>
<HEAD>
<script type="text/javascript" src="functions/jquery.js"></script>	
<script type="text/javascript" src="ckeditor/ckeditor_source.js"></script>
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
cms_insert_flags('did', $data->get("baseData", 'did'));
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
	<input type='hidden' name="did" value="<?php echo $data->get("baseData", 'did'); ?>">
	<input type='hidden' name="module_signature" value="<?php echo $prop['module_signature']; ?>">
	<TABLE BORDER=0 id="standardInfo" WIDTH=100%>
	<?php
	echo "<tr><th>Public Url:</th><th colspan=3>";
	$url = $SITE_INFO_PUBLIC_ROOT.$_SESSION['lang']."/page".$data->get("baseData", 'did');
	echo "<a href=\"$url\">$url</a>";
	echo "</th></tr>";
	//print the mandatory text
	insert_mandatory_fields();
	echo "</table>";
	//insert module text fields
	insert_module_fields();
	
	?>
	<TR>
	<TR><TH COLSPAN=4 style="text-align:left;">
           <INPUT TYPE="submit" value="save" name="saveDoc">
	</TH></TR></table>
	</FIELDSET>
	</form>
	<BR>
		<?//require_once("modules/".$prop['cms_path'].".php");
		//showCMSModuleForm();?>	
	
<?php
	if ($data->get('did') != NULL) {
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
	   <?php echo selectParent(" - SELECT PARENT TO DELETE -", "delp", 1, $data->get('did')); ?> <INPUT TYPE="submit" NAME="delParent" VALUE="Remove as parent">

	   <?php //if index
		   echo "<HR>";
		   echo selectDocument("- SELECT CHILD TO ADD -", "addc", 1, null);
		   echo "<INPUT TYPE='submit' NAME='addChild' VALUE='Set as child'>";
		   echo "<BR>";
		   echo selectChild("- SELECT CHILD TO REMOVE -", "delc", 1, $data->get('did')); 
		   echo "<INPUT TYPE='submit' NAME='delChild' VALUE='Remove as child'>";
	   ?>
	   </FORM>
	   </FIELDSET>
	   <?php
	}
?>
<A HREF='listDocs.php'>Back to list of documents</A></BODY>
</HTML>
