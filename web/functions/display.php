<?php
require_once("functions.php");
require_once("path.php");
require_once("documentBase.php");
require_once("listings.php");

function getDocumentProperties($did) {
	/* get current document properties */
	$query = "SELECT did, lang.langid, lang.shorthand, lang.iid, lang.lname, pagetitle, header, postheader, body ";
	$query .= "FROM doc_regular_v, lang ";
	$query .= "WHERE doc_regular_v.langid = lang.langid AND did='$did' ";
	$query .= " ORDER BY lang.priority DESC";
	//echo $query;
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
	$main_trans['body'] = fixBody($did, $main_trans['body']);
	return array ( "main"=>$main_trans, "tnames"=>$translationNames, "tpaths"=>$translationPaths, "usedlang"=>$usedlang, "parents"=>$parents );
}

function fixBody($did, $body) {
	$body=stripslashes($body);
	//echo "fixBody called";
	//$pattern="/\\\\'/";
	//$replacement="'";
	//preg_replace($pattern, $replacement, $body);
	/** FIX INDEXES **/
	$regularType = documentIndex($did, false, true, true, 1);
	$simple = documentIndex($did, false, false, true, 1);
	$withDescription = documentIndex($did, true, false, true, 1);
	$body = str_ireplace("##indexList::regularType##", $regularType, $body);
	$body = str_ireplace("##indexList::simple##", $simple, $body);
	$body = str_ireplace("##indexList::withDescription##", $withDescription, $body);

//echo $body;
	global $publicRoot;
	/** FIX LINKS **/
	$regexp = "<a href='(\-?[0-9]+)'>";
	while (eregi($regexp, $body, $values)) {
		$query = "SELECT doc.did, doc.format, lang.shorthand ";
		$query .= "FROM doc, lang, doc_general_v ";
		$query .= "WHERE doc.did = '".$values[1]."' AND doc.did = doc_general_v.did ";
		$query .= "AND lang.langid = doc_general_v.langid ";
		$query .= "ORDER BY lang.priority DESC";
		//echo $query;
		$result = mysql_query($query);
		while ($row = mysql_fetch_assoc($result)) {
			if ($row['format'] == 'file') {
				$query = "SELECT path FROM file WHERE fid = '".$row['fid']."'";
				$r = mysql_fetch_row(mysql_query($query));
				$linkaddress = "<A HREF='".$publicRoot.$r[0]."' TARGET='_blank'";
			} else {
				if ($row['format'] == 'link') {
					$linkaddress = $row['link'];
				} else {
					$linkaddress = pageLink($row['did'], null, $row['shorthand']);
				}
				$linkaddress = "<A HREF='$linkaddress'";
			}

			if ($row['shorthand'] == $_GET['tmplang'] || ($row['shorthand'] == $_GET['lang'] && $means == "default") || $link == null) {
				if ($link == null) $means = "default";
				$link = $linkaddress.">";
			}
		}
		//echo "REPLACING STRING: $values[0] WITH $link<HR>";
		$body = str_replace($values[0], $link, $body);
	}

	/** FIX IMAGES **/
	$regexp = "<img src='([0-9]+)'>";
	while (eregi($regexp, $body, $values)) {
		$result = mysql_query("SELECT small, big FROM images WHERE iid='".$values[1]."'");
		if ($row = mysql_fetch_row($result)) {
			if ($row[1] != "") {
				$body = str_replace($values[0], "<A HREF='$publicRoot$row[1]' TARGET='_blank'><img src='$publicRoot$row[0]' BORDER='0'></A>", $body);
			} else {
				$body = str_replace($values[0], "<img src='$publicRoot$row[0]'>", $body);
			}
		}
	}
	return $body;
}

function getParents($did) {
	global $publicRoot;
	$query = "SELECT doc.did, lang.langid, lang.shorthand, lang.lname, doc_general_v.linktext ";
	$query .= "FROM doc_general_v, lang, doc, hierarchy ";
	$query .= "WHERE doc_general_v.langid = lang.langid AND doc_general_v.did = doc.did AND hierarchy.parent = doc.did ";
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
		$flags .= "<A HREF='".pageLink($row['did'], null, $row['shorthand'])."'><IMG SRC='".$publicRoot.$row['small']."' CLASS='linkflags'></A>";
		$prevRow = $row;
	}
	$parents[] = $link . $flags;
	return $parents;
}
?>
