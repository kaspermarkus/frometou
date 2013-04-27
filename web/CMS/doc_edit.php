<?php
header('Content-Type: text/html; charset=iso-8859-1');
require_once("system/authorize.php");
require_once("functions/cms_general.php");
require_once("functions/parsing.php");


//if new language chosen
if (isset($_GET['lang'])) {
    $_SESSION['lang'] = $_GET['lang'];
}

//If we changed document, load it
if (isset($_GET['did']) || isset($_GET['did'])) {
    $_SESSION['did'] = isset($_GET['did']) ? $_GET['did'] : $_POST['did'];
    $did = $_SESSION['did'];
    //load the doc
    $doc = new doc;
    $doc->load($did);
    $_SESSION['doc'] = serialize($doc);    

    //Load the 'general' modules
    $modules = [];
    $query = "SELECT * FROM module WHERE module_type='general' && enabled=1";
    $result = mysql_query($query);
    while ($row = mysql_fetch_array($result)) {
        require ($row["cms_path"]);
        $modname = $row["module_name"];
        $mod = new $modname;
        $mod->load($did);
        $modules[$modname] = $mod;
    }
    $_SESSION['modules'] = serialize($modules); 
}

$doc = unserialize($_SESSION['doc']);
$modules = unserialize($_SESSION['modules']);

//save if user has clicked saved
if (isset($_POST['saveDoc'])) {
    $doc->save($_POST, $_SESSION['lang']);
}
?>
<HTML>
<HEAD>

<!-- updating the changes to navigation window -->
<SCRIPT>parent.navigation.location.href = 'navigator.php';</script>

<script type="text/javascript" src="lib/jquery.js"></script>   
<!-- CKEDITOR STUFF START --> 
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
<!-- CKEDITOR STUFF END --> 

<LINK REL="stylesheet" type="text/css" href="layout/css/general.css">
<title>Edit/add documents</title>
</HEAD>
	<BODY>
	<TABLE BORDER=0 WIDTH='100%'>
		<TR>
			<TD><H1>Edit/add Documents</H1></TD>
			<td><a href='delete.php'><b>Delete this Document</b></a></h1></td>
			<TD ALIGN='right'>
			<?php
				cms_insert_flags('did', $doc->did);
			?>
			</TD>
		</TR>
	</TABLE>
<?php
if (isset($_GET['new'])){
	echo "<h1>You are now creating a new version of this document</h1>";
}
?>

<HR>
<FORM name="f1" target="_self" method="post" action="doc_edit.php?did=<?php echo $doc->did; ?>" onSubmit="return submitForm();">
    <FIELDSET ID="documentInfo"><LEGEND><B>
        <A HREF="#" onClick="showhide('documentInfoSub'); showhide('cke_bodyEdit'); return false;">
            Document properties <font id="documentInfoSubPlus" style="display:none;">+</font>
        </A></B></LEGEND>
        <?php $doc->printEditArea(); ?>
    </FIELDSET>
    </form>

    <BR>
    
<?php

//Display the 'general' modules
foreach ($modules as $name => $mod) {
    $mod->printEditArea();
}

?>
</table>
</BODY>
</HTML>
