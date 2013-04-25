<?php
require_once("functions/cms_general.php");
require_once("functions/parsing.php");
require_once("functions/delete.php");
?>

<h1>Delete this file???!!!!</h1><br>
WARNING! When a file is deleted you cannot restore it!!!! <br><br>


<form target="_self" method="post" >
<INPUT TYPE='submit' value='Delete' name='DeleteAll' OnClick="return confirm('Are you sure you want to delete this page in all languages?');" /> Delete this File ...NAME... in all languages.<br><br>
<?php

//If DeleteAll is posted, run delete script for all pages.
if (isset($_POST['DeleteAll'])){
	DeleteDocForm($_SESSION['ThisDid']);
	$_SESSION['ThisDid'] = null;
	echo "<script>window.location.href = '../cms/main.php';</script>";
}


//listing all languages version of the given document  
$mysql = "SELECT langid, did FROM doc_module_v WHERE prop_signature = 'normal_page_header' AND did = '".$_SESSION['ThisDid']."' ORDER BY did DESC";
$result = mysql_query($mysql);
while ($row = mysql_fetch_assoc($result)) {
	echo "<INPUT TYPE='submit' value='Delete".$row['langid']."' name='".$row['langid']."'  OnClick='return confirm(\"Are you sure you want to delete this page in ".$row['langid']."?\");' />Delete the ".$row['langid']." language version of this document<br>";

	//If delete of the given languages is posted, run delete script, and update page to changes
	if (isset($_POST[$row['langid']])){
		echo $_POST[$row['langid']];
		DeleteDocLangForm($_SESSION['ThisDid'],$row['langid']);
		echo "<script>window.location.href = '../cms/main.php';</script>";
		echo "<script>window.location.href = '../cms/delete.php';</script>";
	}
}

?>



</form>