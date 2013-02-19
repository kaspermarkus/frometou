<?php


function leftMenu() {

	global $SITE_INFO_PUBLIC_ROOT;
	global $props;
	$types = getTypes();

	function menuQuery($hierarchyParent){
		$query = "SELECT doc.did, doc_general_v.linktext FROM doc, doc_general_v, lang, hierarchy ";
		$query .= "WHERE hierarchy.parent = ".$hierarchyParent." AND doc.did = hierarchy.did AND doc.did = doc_general_v.did ";
		$query .= "AND lang.id = doc_general_v.langid AND lang.id = '".$_SESSION['lang']."' "; 
		$query .= "ORDER BY doc.priority DESC";
		$result = mysql_query($query);
		return $result;
	}

	//Getting child list
	$result = menuQuery($props->get("did"));
	$childlist = "<ul class='childMenu'>\n";
	while ($row = mysql_fetch_assoc($result)) {
		$childlist .= "<li><A HREF='".pageLink($row['did'])."' CLASS='leftmenu-links'>".$row['linktext']."</A></li>\n";
	}
	$childlist .= "</ul>\n";


	//Getting menu
	$result = menuQuery("0");
	$prevRow;
	$link = null;
	$out = "<ul>\n";
	while ($row = mysql_fetch_assoc($result)) {
		if ($link != null) {
			$out .= $link;
		}
		$linkaddress = pageLink($row['did']);
		$linkaddress = "<li><A HREF='$linkaddress' CLASS='leftmenu-links'>".$row['linktext']."</A></li>\n";
		if ($props->get("did") == $row['did']) {
			$linkaddress .= $childlist;
		}
		$link = $linkaddress;

	}

	if ($link != null) {
		$out .= $link;
	}
	$out .= "</ul>";
	return $out;
}

?>