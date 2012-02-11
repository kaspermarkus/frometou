<?php
require_once("siteInfo.php");
require_once("functions.php");
require_once("path.php");

function documentIndex($did, $description, $types, $flags, $levels) {
	if ($flags == true && $levels == 1 && $description == false && $types == true) {
		return indexTypeFlags1($did);
	} else if ($flags == true && $levels == 1 && $description == false && $types == false) {
		return indexFlags1($did);
	} else if ($flags == true && $levels == 1 && $description == true) {
		return indexDescriptionFlags($did);
	}
}

function leftMenu() {
	global $SITE_INFO_PUBLIC_ROOT;
	$types = getTypes();

	$query .= "SELECT doc.did, lang.shorthand, doc_v.linktext, doc_v.fid, doc_v.link, doc_v.module_signature FROM doc, doc_v, lang, hierarchy ";
	$query .= "WHERE hierarchy.parent = '0' AND doc.did = hierarchy.did AND doc.did = doc_v.did AND lang.langid = doc_v.langid ";
	$query .= "AND lang.shorthand = '".$_GET['lang']."' ";
	$query .= "ORDER BY doc.priority DESC, doc.did ASC, lang.priority DESC";
	$result = mysql_query($query);
	$prevRow;
	while ($row = mysql_fetch_assoc($result)) {
		if ($link != null) {
			$out .= "<TR><TD CLASS='leftmenu-links'>".$link."</TD></TR>\n";
		}
		if ($row['module_signature'] == 'file') {
			$r = mysql_fetch_row(mysql_query("SELECT path FROM file WHERE fid = '".$row['fid']."'"));
			$linkaddress = "<A HREF='$SITE_INFO_PUBLIC_ROOT".$r[0]."' TARGET='_blank'>";
		} else {
			if ($row['module_signature'] == 'link') {
				$linkaddress = $row['link'];
			} else {
				$linkaddress = pageLink($row['did'], null, null);
			}
			$linkaddress = "<A HREF='$linkaddress'>";
		}
		$link = $linkaddress.$row['linktext']."</A>";
	}
	if ($link != null) {
		$out .= "<TR><TD>".$link."</TD></TR>\n";	
	}
	return $out;
}

function indexTypeFlags1($did) {
	global $SITE_INFO_PUBLIC_ROOT;
	$types = getTypes();

	$query = "SELECT doc.did, lang.shorthand, lang.lname, doc_v.linktext, dtype.tid, images.small, doc_v.fid, doc_v.link, doc_v.module_signature ";
	$query .= "FROM doc, doc_v, dtype, lang, hierarchy, images ";
	$query .= "WHERE hierarchy.parent = '".$did."' AND doc.did = hierarchy.did AND doc.did = doc_v.did AND dtype.tid = doc.typeid ";
	$query .= "AND lang.langid = doc_v.langid AND images.iid = lang.iid ";
	$query .= "ORDER BY dtype.priority DESC, doc.priority DESC, doc.did ASC, lang.priority DESC";
	$result = mysql_query($query);
	$typeid = null;
	$output = "<UL>";
	$prevRow;
	while ($row = mysql_fetch_assoc($result)) {
		if ($prevRow != null && $prevRow['did'] != $row['did']) {
			if ($flags != "") {
				$typeoutput .= "<LI>".$link." ".$flags."</LI>\n";
			}
			$flags = null;
			$link = null;
			$means = null;
		}
		if ($prevRow != null && $prevRow['tid'] != $row['tid']) {
			if ($prevRow['tid'] != 0) {
				$output .= "<LI CLASS='listingTypeHeader'>".$types[$prevRow['tid']]."</LI>\n";
				$output .= "<UL>".$typeoutput."</UL>\n";
				$typeoutput = null;
			} else {
				$output .= $typeoutput;
				$typeoutput = null;
			}
		}
		if ($row['module_signature'] == 'file') {
			$query = "SELECT path FROM file WHERE fid = '".$row['fid']."'";
			$r = mysql_fetch_row(mysql_query($query));
			$linkaddress = "<A HREF='".$r[0]."' TARGET='_blank'";
		} else {
			if ($row['module_signature'] == 'link') {
				$linkaddress = $row['link'];
			} else {
				$linkaddress = pageLink($row['did'], null, $row['shorthand']);
			}
			$linkaddress = "<A HREF='$linkaddress'";
		}
		$linkaddress .= ($row['tid'] == 0) ? " CLASS='listingTypeIndexLink'>" : " CLASS='listingTypeLink'>";

		if ($row['shorthand'] == $_GET['lang'] || ($row['shorthand'] == $_GET['tmplang'] && $means == "default") || $link == null) {
			if ($link == null) $means = "default";
			$link = $linkaddress.(($linktext == null)?$row['linktext']:$linktext)."</A>";
		}
		$flags .= $linkaddress."<IMG SRC='".$SITE_INFO_PUBLIC_ROOT.$row['small']."' CLASS='linkflags' ALT=\"".$row['flagtext']."\"></A>";
		$prevRow = $row;
	}
	if ($typeoutput != null) {
		if ($prevRow['tid'] != 0) {
			$typeoutput .= "<LI>".$link." ".$flags."</LI>";
			$output .= "<LI  CLASS='listingTypeHeader'>".$types[$prevRow['tid']]."</LI>";
			$output .= "<UL>".$typeoutput."</UL>";
		} else {
			$typeoutput .= "<LI>".$link." ".$flags."</LI>";
			$output .= $typeoutput;
			$typoutput = null;
		}
	}
	return $output."</UL>";
}

function indexFlags1($did) {
	global $SITE_INFO_PUBLIC_ROOT;
	$query = "SELECT doc.did, lang.shorthand, lang.lname, doc_v.linktext, doc_v.description, doc.description_img, images.small, doc_v.fid, doc_v.link, doc_v.module_signature ";
	$query .= "FROM doc, doc_v, lang, hierarchy, images ";
	$query .= "WHERE hierarchy.parent = '".$did."' AND doc.did = hierarchy.did AND doc.did = doc_v.did ";
	$query .= "AND lang.langid = doc_v.langid AND images.iid = lang.iid ";
	$query .= "ORDER BY doc.priority DESC, doc.did ASC, lang.priority DESC";
	$result = mysql_query($query);
	$output = "<UL='listingFlags'>";
	$prevRow;
	while ($row = mysql_fetch_assoc($result)) {
		if ($prevRow != null && $prevRow['did'] != $row['did']) {
			$output .= "<LI CLASS='listingFlags'>".$link." ".$flags."</LI>\n";
			$flags = null;
			$link = null;
			$means = null;
		}
		if ($row['module_signature'] == 'file') {
			$query = "SELECT path FROM file WHERE fid = '".$row['fid']."'";
			$r = mysql_fetch_row(mysql_query($query));
			$linkaddress = "<A HREF='".$r[0]."' TARGET='_blank'";
		} else {
			if ($row['module_signature'] == 'link') {
				$linkaddress = $row['link'];
			} else {
				$linkaddress = pageLink($row['did'], null, $row['shorthand']);
			}
			$linkaddress = "<A HREF='$linkaddress'";
		}
		$linkaddress .= " CLASS='listingFlags'>";

		if ($row['shorthand'] == $_GET['lang'] || ($row['shorthand'] == $_GET['tmplang'] && $means == "default") || $link == null) {
			if ($link == null) $means = "default";
			$link = $linkaddress.(($linktext == null)?$row['linktext']:$linktext)."</A>";
			$description = $row['description'];
			$description_img = $row['description_img'];
		}
		$flags .= $linkaddress."<IMG SRC='".$SITE_INFO_PUBLIC_ROOT.$row['small']."' CLASS='linkflags' ALT=\"".$row['flagtext']."\"></A>";
		$prevRow = $row;
	}
	if ($prevRow != null) {
		$output .= "<LI CLASS='listingFlags'>".$link." ".$flags."</LI>\n";
	}
	return $output."</UL>";
}


function indexDescriptionFlags($did) {
	global $SITE_INFO_PUBLIC_ROOT;
	$query = "SELECT doc.did, lang.shorthand, lang.lname, doc_v.linktext, doc_v.description, doc.description_img, images.small, doc_v.fid, doc_v.link, doc_v.module_signature ";
	$query .= "FROM doc, doc_v, lang, hierarchy, images ";
	$query .= "WHERE hierarchy.parent = '".$did."' AND doc.did = hierarchy.did AND doc.did = doc_v.did ";
	$query .= "AND lang.langid = doc_v.langid AND images.iid = lang.iid ";
	$query .= "ORDER BY doc.priority DESC, doc.did ASC, lang.priority DESC";
	$result = mysql_query($query);
	$output = "<TABLE CLASS='listingDescriptionFlags'>";
	$prevRow;
	while ($row = mysql_fetch_assoc($result)) {
		if ($prevRow != null && $prevRow['did'] != $row['did']) {
			$output .= "<TR><TH COLSPAN=2 ALIGN='left'>".$link." ".$flags."</TH></TR>\n";
			$output .= "<TR><TD WIDTH=100% VALIGN='top'>".$description."</TD><TD>";
			if ($description_img != "" && $description_img != "-1") {
				$query = "SELECT small FROM images WHERE iid=".$description_img;
				$r = mysql_query($query);
				if ($r = mysql_fetch_row($r)) {
					$output .= "<IMG SRC='".$r[0]."' CLASS='listingDescriptionFlagsImg'>";
				}
			}
			$output .= "</TD></TR>\n";
			$output .= "<TR><TD COLSPAN=2><HR></TD></TR>";
			$flags = null;
			$link = null;
			$means = null;
			$description = null;
			$description_img = null;
		}
		if ($row['module_signature'] == 'file') {
			$query = "SELECT path FROM file WHERE fid = '".$row['fid']."'";
			$r = mysql_fetch_row(mysql_query($query));
			$linkaddress = "<A HREF='".$r[0]."' TARGET='_blank'";
		} else {
			if ($row['module_signature'] == 'link') {
				$linkaddress = $row['link'];
			} else {
				$linkaddress = pageLink($row['did'], null, $row['shorthand']);
			}
			$linkaddress = "<A HREF='$linkaddress'";
		}
		$linkaddress .= " CLASS='listingDescriptionFlags'>";

		if ($row['shorthand'] == $_GET['lang'] || ($row['shorthand'] == $_GET['tmplang'] && $means == "default") || $link == null) {
			if ($link == null) $means = "default";
			$link = $linkaddress.(($linktext == null)?$row['linktext']:$linktext)."</A>";
			$description = $row['description'];
			$description_img = $row['description_img'];
		}
		$flags .= $linkaddress."<IMG SRC='".$SITE_INFO_PUBLIC_ROOT.$row['small']."' CLASS='linkflags' ALT=\"".$row['flagtext']."\"></A>";
		$prevRow = $row;
	}
	if ($prevRow != null) {
		$output .= "<TR><TH COLSPAN=2 ALIGN='left'>".$link." ".$flags."</TH></TR>\n";
		$output .= "<TR><TD WIDTH=100% VALIGN='top'>".$description."</TD><TD>";
		if ($description_img != "" && $description_img != "-1") {
			$query = "SELECT small FROM images WHERE iid=".$description_img;
			$r = mysql_query($query);
			if ($r = mysql_fetch_row($r)) {
				$output .= "<IMG SRC='".$r[0]."' CLASS='listingDescriptionFlagsImg'>";
			}
		}
		$output .= "</TD></TR>\n";
	}
	return $output."</TABLE>";
}



function getTypes() {
	$query = "SELECT dtype.tid, dtype_v.tname, lang.shorthand FROM dtype, dtype_v, lang WHERE dtype_v.tid = dtype.tid AND lang.langid = dtype_v.langid";
	$result = mysql_query($query);
	while ($row = mysql_fetch_assoc($result)) {
		if ($row['shorthand'] == $_GET['lang']) {
			$types[$row['tid']] = $row['tname'];
			continue;
		} else if ($types[$row['tid']] == null) {
			$types[$row['tid']] = $row['tname'];
		}
	}
	return $types;
}
?>
