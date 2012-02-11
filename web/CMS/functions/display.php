<?php
require_once("functions.php");
require_once("path.php");
require_once("siteInfo.php");
require_once("listing.php");

function getDocumentProperties($did) {
	/* get current document properties */
	$query = "SELECT did, lang.langid, lang.shorthand, images.small, lang.lname, pagetitle, header, postheader, description, body ";
	$query .= "FROM doc_v, lang, images ";
	$query .= "WHERE doc_v.langid = lang.langid AND images.iid = lang.iid AND did='$did' ";
	$query .= " ORDER BY lang.priority DESC";
	$result = mysql_query($query);
	$main_trans = null;
	$means = null;
	$usedlang;
	while ($row = mysql_fetch_assoc($result)) {
		if ($row['shorthand'] == $_GET['tmplang']) {
			$main_trans = $row;
			$usedlang = $row['shorthand'];
			$means = "tmplang";
		} else if ($row['shorthand'] == $_GET['lang'] && $means != 'tmplang') {
			$main_trans = $row;
			$usedlang = $row['shorthand'];
			$means = 'lang';
		} else if ($means == null) {
			$main_trans = $row;
			$usedlang = $row['shorthand'];
			$means = 'default';
		}
		$translationNames[$row['shorthand']] = $row['lname'];
		$translationPaths[$row['shorthand']] = $row['small'];
	}
	$parents = getParents($did);
	$main_trans['body'] = fixBody($did, $main_trans);
	return array ( "main"=>$main_trans, "tnames"=>$translationNames, "tpaths"=>$translationPaths, "usedlang"=>$usedlang, "parents"=>$parents );
}

function fixBody($did, $body) {
	$regularType = documentIndex($did, false, true, true, 1);
	$simple = documentIndex($did, false, false, true, 1);
	$withDescription = documentIndex($did, true, false, true, 1);
	$body = str_ireplace("##indexList::regularType##", $regularType, $body);
	$body = str_ireplace("##indexList::simple##", $simple, $body);
	$body = str_ireplace("##indexList::withDescription##", $withDescription, $body);
	return $body;
}

function getParents($did) {
	global $SITE_INFO_PUBLIC_ROOT;
	$query = "SELECT doc.did, lang.langid, lang.shorthand, images.small, lang.lname, doc_v.linktext ";
	$query .= "FROM doc_v, lang, images, doc, hierarchy ";
	$query .= "WHERE doc_v.langid = lang.langid AND images.iid = lang.iid AND doc_v.did = doc.did AND hierarchy.parent = doc.did ";
	$query .= "AND hierarchy.did = '$did' ";
	$query .= " ORDER BY doc.priority DESC, doc.did ASC,  lang.priority DESC";
	$result = mysql_query($query);

	while ($row = mysql_fetch_assoc($result)) {
		if (isset($prevRow) && $row['did'] != $prevRow['did']) {
			$parents[] = $link . $flags;
			$flags = null;
			$means = null;
		}
		if ($row['shorthand'] == $_GET['lang']) {
			$link = "<A HREF='".pageLink($row['did'], null, null)."'>".$row['linktext']."</A>";
			$means = "lang";
		} else if ($means == null) {
			$link = "<A HREF='".pageLink($row['did'], null, $row['shorthand'])."'>".$row['linktext']."</A>";
			$means = 'default';
		}
		$flags .= "<A HREF='".pageLink($row['did'], null, $row['shorthand'])."'><IMG SRC='".$SITE_INFO_PUBLIC_ROOT.$row['small']."' CLASS='linkflags'></A>";
		$prevRow = $row;
	}
	$parents[] = $link . $flags;
	return $parents;
}
?>