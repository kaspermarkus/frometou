<?php
require_once("functions/cms_general.php");


//
function availableLang(){
	$availableLang = [];
	$mysql = "SELECT id, thumbnail_path FROM lang ORDER BY priority DESC";
	$result = mysql_query($mysql);
	while ($row = mysql_fetch_assoc($result)) {
		$availableLang[$row['thumbnail_path']] = $row['id'];
	}
return $availableLang;
}



/* insert flags on the page to change the current language. Used when editing pages, etc. */
function docFlags($did) {
	$availableLang = availableLang();
	global $SITE_INFO_PUBLIC_ROOT, $SITE_INFO_LANGS_ENABLED;

	foreach ($availableLang as $langImg => $langId) {
		$mysql = "SELECT langid, did FROM doc_module_v WHERE prop_signature = 'normal_page_header' AND did = '$did' AND langid = '$langId' ORDER BY did DESC";

		$result = mysql_query($mysql);
		while ($row = mysql_fetch_assoc($result)) {
			//splitting the output
			if (isset($row['langid'])) {
				$langInUse = $row['langid'];
			}
		}

		if (isset($langInUse)) {
			//checking for the selected flag (the flag in use)
			if($langInUse == $_SESSION['lang'] and $did == $_SESSION['ThisDid']) {
				echo "<a class='selectedDoc' href='editDocs.php?did=".$did."&lang=".$langId."'>";
				echo "<IMG SRC='".$SITE_INFO_PUBLIC_ROOT.$langImg."' WIDTH='22' HEIGHT='14' BORDER=2>";
				echo "</a>";
			}else{
				echo "<a class='selectedDoc' href='editDocs.php?did=".$did."&lang=".$langId."'>";
				echo "<IMG SRC='".$SITE_INFO_PUBLIC_ROOT.$langImg."' WIDTH='22' HEIGHT='14' BORDER=0> ";
				echo "</a>";
			}
		}else{
			if($langId == $_SESSION['lang'] and $did == $_SESSION['ThisDid']) {
				echo "<a class='selectedDoc' href='editDocs.php?did=".$did."&lang=".$langId."'>";
				echo "<IMG SRC='".$SITE_INFO_PUBLIC_ROOT.$langImg."' WIDTH='22' HEIGHT='14' BORDER=2>";
				echo "</a>";
			}else{
				echo "<a class='selectedDoc' href='editDocs.php?did=".$did."&lang=".$langId."'>";
				echo "<IMG SRC='".$SITE_INFO_PUBLIC_ROOT.$langImg."' WIDTH='11' HEIGHT='7' BORDER=0> ";
				echo "</a>";
			}
		}
		$langInUse = null;
	}
}

function ListDocs($did){
	$query = "SELECT did, ident FROM frometou_db.doc ORDER BY ident";
	$result = mysql_query($query) or die(mysql_error());
	while ($row = mysql_fetch_array($result)) {
		if ($did == $row['did']){
			echo "<TR><TD><a class='selectedDoc' href='editDocs.php?did=".$row['did']."'> ".$row['ident']."</a>";
			echo docFlags($row['did']);
			echo "</TD></TR>";
		} else {
			echo "<TR><TD><a href='editDocs.php?did=".$row['did']."'> ".$row['ident']."</a> ";
			echo docFlags($row['did']);
			echo "</TD></TR>";
		}
	}
}

	ListDocs($_SESSION['ThisDid']);
	availableLang();
?>
