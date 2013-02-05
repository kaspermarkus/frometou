<?php
header('Content-Type: text/html; charset=iso-8859-1');

require_once("functions/cms_general.php");
require_once("functions/parsing.php");

$filename = "editDocs.php";
//print_r( $_POST );

class dataContainer {
	var $data = [];
	function add($category, $query) {
		//echo $query;
		$result = mysql_query($query);
		if ($result && mysql_num_rows($result) > 0) {
			$prev = isset($this->data[$category]) ? $this->data[$category] : [];
			$this->data[$category] = array_merge($prev, mysql_fetch_assoc($result));
			//print_r($this->data);
			return true;
		}
		return false;
	}

	function get($key, $category="baseData") {
		return (isset($this->data[$category]) && isset($this->data[$category][$key])) ? $this->data[$category][$key] : NULL;
	}

	function show($key, $category="baseData") {
		echo (isset($this->data[$category]) && isset($this->data[$category][$key])) ? $this->data[$category][$key]  : "";
	}

	function init($did) {
		if (!isset($did)) {
			echo $did;
			die();
			header("location:listDocs.php");$data->loadTranslation($_SESSION['lang']);
		}
		$this->add("baseData", "SELECT doc.module_signature, doc.did, doc.priority, module_name, cms_path, ident, typeid, description_img ".
			"FROM doc, module ".
			"WHERE doc.module_signature = module.module_signature AND doc.did=".$did);
 		//load module:
		require_once($this->get("cms_path"));
		$module_sig = $this->get("module_signature");
		$this->data['modules'][$module_sig] = new $module_sig;
	}

	function loadTranslation($lang) {
		$this->data["baseData"]["lang"] = $lang;
		$query = "SELECT linktext, description, pagetitle ";
		$query .= "FROM doc_general_v WHERE did=".$this->get('did')." AND langid='".$lang."'";
		$this->add("baseData", $query);
		foreach($this->data['modules'] as $n=>$o) {
			$o->init($this->get('did'), $lang);
		}		
	}

	function save($post, $lang) {
		//first update the general properties:
		$query = "UPDATE doc SET priority = ".$post['priority'].", typeid=".$post['typeid'].", ident=\"".$post['ident']."\", description_img=\"".$post['description_img']."\" WHERE id='".$this->get("did")."'";
		//echo $query;
		mysql_query($query);
		//update translation specific general properties
		$query = "REPLACE doc_general_v ( did, langid, linktext, pagetitle, description ) VALUES ( ".$post['did'].", ".$lang.", \"".$post['linktext']."\", \"".$post['pagetitle']."\", \"".$post['description']."\")"; 
		//echo $query."<br />";		
		mysql_query($query);
		foreach($this->data['modules'] as $n=>$o) {
			$o->save($post, $lang);
		}
	}

	function delete($lang) {
		$query = "DELETE FROM doc_general_v WHERE did=".$this->get('did')." AND langid=".$lang; 
		mysql_query($query);
		foreach($this->data['modules'] as $n=>$o) {
			$o->delete($lang);
		}
	}

	function printHTMLForm() {
		global $SITE_INFO_PUBLIC_ROOT;
		?>
		<input type='hidden' name="did" value="<?php $this->show('did'); ?>">
		<!-- <input type='hidden' name="module_signature" value="<?php echo $prop['module_signature']; ?>"> -->
		<TABLE BORDER=0 id="standardInfo" WIDTH=100%>
		<tr><th>Public Url:</th><th colspan=3>
		<?php
		$url = $SITE_INFO_PUBLIC_ROOT.$_SESSION['lang']."/page".$this->get('did');
		echo "<a href=\"$url\">$url</a>";
		?>
		</th></tr>;
		<TR><TH>identifier: </TH><TD><input TYPE='text' size="50" name="ident" value="<?php $this->show('ident'); ?>"></TD>
	   	    <TH STYLE="width:0; text-align:right;">priority: </TH><TD WIDTH=100%><input TYPE='text' size="3" name="priority" value="<?php $this->show('priority'); ?>"></TD>
		    <TD WIDTH=0><INPUT TYPE="submit" value="&nbsp;save&nbsp;" name="saveDoc"></TD></TR>

		<TR><TH STYLE="width:0;">type: </TH><TD style="width:0;"> <?php echo selectType("typeid", 1, $this->get('typeid')); ?></TD>
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
		 <input type='hidden' NAME='description_img'  id="description_img_form_field" VALUE="<?php $this->show('description_img'); ?>" name='description_img'>
		<A HREF="#" class="kfm" onClick="javascript:update_description_img()"><IMG WIDTH='150px' SRC="<?php echo $SITE_INFO_PUBLIC_ROOT.($this->get('description_img')?$this->get('description_img'):'imgs/no_img.svg'); ?>" id="description_img" /> </A></TD>
	   	   <TD style="text-align:right"><INPUT TYPE="submit" value="delete" onsubmit="return confirm('Really delete this translation of the document?');" name="delete"></TD>
		</TR>
		<TR><TH>page title:</TH><TD><input size="50" name="pagetitle" value="<?php $this->show("pagetitle"); ?>"</TD>
	   	    <TD></TD><TD></TD>

		<TR><TH>linktext:</TH><TD><input size="50" name="linktext" value="<?php $this->show("linktext"); ?>"</TD>
	   	    <TD></TD><TD></TD>
		</TR>
		<TR><TH>description: </TH><TD><TEXTAREA COLS=50 ROWS=3 NAME='description'><?php $this->show("description"); ?></TEXTAREA></TD>
		    <TD></TD><TD></TD>
		</TR>
		<TR>
		<TR><TH COLSPAN=4 style="text-align:left;">
	           <INPUT TYPE="submit" value="save" name="saveDoc">
		</TH></TR></table>
		<?php
		foreach($this->data['modules'] as $n=>$o) {
			$o->printHTMLForm();
		}
	}
}


//load basic document properties into $data
$data = new dataContainer;
$data->init((isset($_GET['did'])) ? $_GET['did'] : $_POST['did']);

//if new language chosen
if (isset($_GET['lang'])) {
	$_SESSION['lang'] = $_GET['lang'];
}

//save if user has clicked saved
if (isset($_POST['saveDoc'])) {
	$data->save($_POST, $_SESSION['lang']);
} else if (isset($_POST['delete'])) {
	//else if user has clicked delete:
	$data->delete($_SESSION['lang']);
}

//load language specific basic properties:
$data->loadTranslation($_SESSION['lang']);
//print_r($data);

/* -------------- categorization ----------------------------------------------- */
//  } else if (isset($_POST['addParent']) && $_POST['addp'] != '-1') {
// 	$mysql = "INSERT INTO hierarchy (parent, did) VALUES (".$_POST['addp'].", ".$data->get('did').")";
// 	mysql_query($mysql);
// 	header("location:$filename?did=".$data->get('did'));
//  } else if (isset($_POST['delParent']) && $_POST['delp'] != '-1') {
// 	mysql_query("DELETE FROM hierarchy WHERE did='".$data->get('did')."' and parent='".$_POST['delp']."'");
// 	header("location:$filename?did=".$data->get('did'));	
// } else if (isset($_POST['addChild']) && $_POST['addc'] != '-1') {
// 	mysql_query("INSERT INTO hierarchy (parent, did) VALUES (".$data->get('did').", ".$_POST['addc'].")");
// 	header("location:$filename?did=".$data->get('did'));
//  } else if (isset($_POST['delChild']) && $_POST['delc'] != '-1') {
// 	mysql_query("DELETE FROM hierarchy WHERE did='".$_POST['delc']."' and parent='".$data->get('did')."'");
// 	header("location:$filename?did=".$data->get('did'));	

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
cms_insert_flags('did', $data->get('did'));
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
	<?php $data->printHTMLForm(); ?>
	</FIELDSET>
	</form>
	<BR>
	
<?php

$query = "SELECT * FROM module WHERE module_type='general' && enabled=1";
$result = mysql_query($query);
while($row = mysql_fetch_array($result)){
    require ($row["cms_path"]);
    $mod = new $row["module_name"];
    $mod->insertEditDocHTML();
}

?>
<A HREF='listDocs.php'>Back to list of documents</A></BODY>

</HTML>