<?php
require_once("functions/cms_general.php");

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
function printDocFlags($did, $docSelected) {
	$availableLang = availableLang();
	global $SITE_INFO_PUBLIC_ROOT, $SITE_INFO_LANGS_ENABLED;

	foreach ($availableLang as $langImg => $langId) {
		$mysql = "SELECT langid, did FROM doc_general_v WHERE did = '$did' AND langid = '$langId' ORDER BY did DESC";
		$result = mysql_query($mysql);

		$translationExist = (mysql_num_rows($result) > 0);
		$isCurrentLang = ($langId == $_SESSION['lang']);

		echo "<a href='doc_edit.php?did=".$did."&lang=".$langId;
		echo ($translationExist) ? "" : "&new=true";
		echo "'><IMG SRC='".$SITE_INFO_PUBLIC_ROOT.$langImg."' ";
		echo ($translationExist) ? "WIDTH='22' HEIGHT='14'" : "WIDTH='11' HEIGHT='7'";
		echo ($isCurrentLang && $docSelected) ? " BORDER=2" : "";
		echo "/></a>";
	}
}

function ListDocs($did){
	$query = "SELECT did, ident FROM frometou_db.doc ORDER BY ident";
	$result = mysql_query($query) or die(mysql_error());
	while ($row = mysql_fetch_array($result)) {
		//add selectedDoc class to <li> if selected - else print normal <li>:
		$isSelected = ($did == $row['did']);
		echo $isSelected ? "<li class='selectedDoc'>" : "<li>";
		//print link and flags:
		echo "<a href='doc_edit.php?did=".$row['did']."'> ".$row['ident']."</a>";
		printDocFlags($row['did'], $isSelected);
		echo "</li>";
	}
}

?>
