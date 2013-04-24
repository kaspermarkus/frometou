<?php
header('Content-Type: text/html; charset=iso-8859-1');

require_once("functions/cms_general.php");
require_once("functions/parsing.php");

$_SESSION['ThisDid'] = $_GET['did'];

//updating the changes to navigation window
echo "<SCRIPT>parent.navigation.location.href = 'navigator.php';</script>";

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
		$this->add("baseData", "SELECT doc.module_signature, doc.did, doc.priority, module_name, cms_path, ident, description_img ".
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
		$query = "UPDATE doc SET priority = ".$post['priority'].", ident=\"".$post['ident']."\", description_img=\"".$post['description_img']."\" WHERE did='".$this->get("did")."'";
		//echo $query;
		mysql_query($query);
		//update translation specific general properties
		$query = "REPLACE doc_general_v ( did, langid, linktext, pagetitle, description ) VALUES ( ".$post['did'].", '".$lang."', \"".$post['linktext']."\", \"".$post['pagetitle']."\", \"".$post['description']."\")"; 
		//echo $query."<br />";		
		mysql_query($query);
		foreach($this->data['modules'] as $n=>$o) {
			$o->save($post, $lang);
		}
		//reinitialize this object, as we've changed some of the base information
		$this->init($this->get("did"));
	}

	function printHTMLForm() {
		global $SITE_INFO_PUBLIC_ROOT;
		?>
		<input type='hidden' name="did" value="<?php $this->show('did'); ?>">
		<!-- <input type='hidden' name="module_signature" value="<?php echo $prop['module_signature']; ?>"> -->
			    <TD WIDTH=0><INPUT TYPE="submit" value="&nbsp;save changes &nbsp;" name="saveDoc"></TD><br><br>
		<TABLE BORDER=0 id="standardInfo" WIDTH=100%>
			<tr>
				<th>Public Url:</th>
				<th>
					<?php
					$url = $SITE_INFO_PUBLIC_ROOT.$_SESSION['lang']."/page".$this->get('did');
					echo "<a href=\"$url\">$url</a>";
					?>
				</th>
	   	    	<TD ROWSPAN=6 STYLE="vertical-align:top; text-align:left;">
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
			                var kfm_url='lib/kfm/';
			                window.open(kfm_url,'kfm','modal,width=600,height=400');
				
					}
					//kfm_init();
					</script>
					<input type='hidden' NAME='description_img'  id="description_img_form_field" VALUE="<?php $this->show('description_img'); ?>" name='description_img' />
					<A HREF="#" class="kfm" onClick="javascript:update_description_img()">
						<IMG WIDTH='150px' SRC="<?php echo $SITE_INFO_PUBLIC_ROOT.($this->get('description_img')?$this->get('description_img'):'imgs/no_img.svg'); ?>" id="description_img" />
					</A>
				</TD>
			</tr>
			<tr>
				<th>identifier: </th>
				<td>
					<input TYPE='text' size="50" name="ident" value="<?php $this->show('ident'); ?>">
				</td>
			</tr>
			<tr>
		   	    <th STYLE="width:0; text-align:right;">priority: </th>
		   	    <td WIDTH=100%><input TYPE='text' size="3" name="priority" value="<?php $this->show('priority'); ?>"></td>
			</tr>
			<TR>
				<TH>page title:</TH>
				<TD>
					<input size="50" name="pagetitle" value="<?php $this->show("pagetitle"); ?>">
				</TD>
			</tr>
			<tr>
				<TH>linktext:</TH>
				<TD><input size="50" name="linktext" value="<?php $this->show("linktext"); ?>"></TD>
			</tr>
			<tr>
				<TH>description: </TH>
				<TD>
					<TEXTAREA COLS=50 ROWS=3 NAME='description'><?php $this->show("description"); ?></TEXTAREA>
				</TD>
			</tr>
		</table>
		<?php
			foreach($this->data['modules'] as $n=>$o) {
			$o->printHTMLForm();
		}
	//mainmenu checkbox
	require_once("modules/mainmenu.php");
    $mod = new mainmenu;
	echo $mod->checkMainMenu($this->get('did'));
   	echo "<br><INPUT TYPE='submit' value='&nbsp;save changes &nbsp;' name='saveDoc' />";
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
}

//load language specific basic properties:
$data->loadTranslation($_SESSION['lang']);
//print_r($data);



?>
<HTML>
<HEAD>
<script type="text/javascript" src="functions/jquery.js"></script>	
<script type="text/javascript" src="lib/ckeditor/ckeditor_source.js"></script>
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
<FORM name="f1" target="_self" method="post" action="editDocs.php?did=<?php echo $data->get('did'); ?>" onSubmit="return submitForm();">
	<FIELDSET ID="documentInfo"><LEGEND><B>
		<A HREF="#" onClick="showhide('documentInfoSub'); showhide('cke_bodyEdit'); return false;">
			Document properties <font id="documentInfoSubPlus" style="display:none;">+</font>
		</A></B></LEGEND>
		<?php $data->printHTMLForm(); ?>
	</FIELDSET>
	</form>

	<BR>
	
<?php
require_once("functions/delete.php");

$query = "SELECT * FROM module WHERE module_type='general' && enabled=1";
$result = mysql_query($query);
while($row = mysql_fetch_array($result)){
    require ($row["cms_path"]);
    $mod = new $row["module_name"];
    $mod->insertEditDocHTML();
}

?>
<A HREF='listDocs.php'>Back to list of documents</A>
</table>
</BODY>
</HTML>
