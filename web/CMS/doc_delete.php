<?php
require_once("functions/cms_general.php");
require_once("functions/parsing.php");

$doc = unserialize($_SESSION['doc']);
$modules = unserialize($_SESSION['modules']);
?>

<h1>Really delete this document???!!!!</h1>
<h3>WARNING! You cannot undo deleting documents!</h3>

<form target="_self" method="post" >
<INPUT TYPE='submit' value='Delete' name='DeleteAll' OnClick="return confirm('Are you sure you want to delete this page in all languages?');" /> Delete this File ...NAME... in all languages.<br><br>
<?php

//If DeleteAll is posted, run delete script for all pages.
if (isset($_POST['DeleteAll'])) {
	$doc->delete();
	//delete the general modules
	foreach ($modules as $modname => $mod) {
		$mod->delete();
	}

	$_SESSION['doc'] = NULL;
	$_SESSION['modules'] = NULL;
	echo "<script>window.location.href = '../cms/main.php';</script>";
}

//listing all languages version of the given document  
$mysql = "SELECT langid, did FROM doc_module_v WHERE prop_signature = 'normal_page_header' AND did = '".$doc->did."' ORDER BY did DESC";
$result = mysql_query($mysql);
//only allow deleting individual document versions if we have more than 1 translation
if (mysql_num_rows($result) > 1) {
	while ($row = mysql_fetch_assoc($result)) {
		echo "<INPUT TYPE='submit' value='Delete ".$row['langid']." version' name='".$row['langid']."' OnClick='return confirm(\"Are you sure you want to delete this page in ".$row['langid']."?\");' />Delete the ".$row['langid']." language version of this document<br>";

		//If delete of the given languages is posted, run delete script, and update page to changes
		if (isset($_POST[$row['langid']])){
			$langid = $row['langid'];
			echo $langid;
			$doc->deleteLang($langid);
			echo "<script>window.location.href = 'doc_edit.php';</script>";
		}
	}
}
?>
</form>