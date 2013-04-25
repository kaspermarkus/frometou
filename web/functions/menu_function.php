<?php

function leftMenu() {

	global $SITE_INFO_PUBLIC_ROOT;
	global $props;
//	$_SESSION['mainenuId'] = 0;
//	echo $_SESSION['mainenuId'];

	function menuQuery($hierarchyParent){
		$query = "SELECT doc.did, doc_general_v.linktext FROM doc, doc_general_v, lang, hierarchy ";
		$query .= "WHERE hierarchy.parent = ".$hierarchyParent." AND doc.did = hierarchy.did AND doc.did = doc_general_v.did ";
		$query .= "AND lang.id = doc_general_v.langid AND lang.id = '".$_SESSION['lang']."' "; 
		$query .= "ORDER BY doc.priority DESC";
		//echo $query;
		$result = mysql_query($query);
		return $result;
	}

	//checking if SESSION
	function getCheck($getDid){
		$query = "SELECT * FROM mainmenu WHERE did = '$getDid'";
		$result = mysql_query($query);
		$row = mysql_fetch_assoc($result);
		if (isset($row['did'])) {
			$_SESSION['mainenuId'] = $row['did'];
		}
		return $row['did'];
 	}
	getCheck($props->get("did"));

	//Getting child list
	function printChildlist($parentDid,$thisDid) {
		$result = menuQuery($parentDid);
		$childlist = "<ul class='chosenPage'>\n";
		while ($row = mysql_fetch_assoc($result)) {
			//checking chosen link
			if ($thisDid == $row['did']) {
				$childlist .= "<li><A HREF='".pageLink($row['did'])."' class='chosenLink'>".$row['linktext']."</A></li>\n";
			}else{
				$childlist .= "<li><A HREF='".pageLink($row['did'])."' CLASS='leftmenu-links'>".$row['linktext']."</A></li>\n";
			}
		}
		$childlist .= "</ul>\n";
		return $childlist;
	}

	//Printing menu wih parents and childs
	$query = "SELECT mainmenu.did, doc_general_v.did, doc_general_v.linktext FROM mainmenu, doc_general_v WHERE mainmenu.did = doc_general_v.did AND langid = '".$_SESSION['lang']."'";
	$result = mysql_query($query);
	$prevRow;
	$link = null;
	$out = "<ul>\n";
	while ($row = mysql_fetch_assoc($result)) {
		if ($link != null) {
			$out .= $link;
		}
		$linkaddress = pageLink($row['did']);
			
		//checking chosen link
		if ($props->get("did") == $row['did']) {
			$linkaddress = "<li><A HREF='$linkaddress' class='chosenLink'>".$row['linktext']."</A></li>\n";
		}else{
			$linkaddress = "<li><A HREF='$linkaddress' CLASS='leftmenu-links'>".$row['linktext']."</A></li>\n";
		}


		if ($props->get("did") == $row['did'] || $_SESSION['mainenuId'] == $row['did']) {
			//$_SESSION['mainmenu'] = $row['did'];
			$linkaddress .= printChildlist($row['did'],$props->get("did"));
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