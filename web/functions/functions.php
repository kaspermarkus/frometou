<?php

/* ---------------------------------- FOR GETTING TRANSLATION ----------------------------------------------------------------------------------------------*/
  /* returns row with langid==$_GET['lid'], else langid==$_GET['langid'] else first row in resultset, else returns null */
function getTranslation($query) {
	$pref = null;
	$result = mysql_query($query);
	//echo $query;
	while ($row = mysql_fetch_assoc($result)) {
		if ($row['langid'] == $_GET['lid']) {
			return $row;
		} else if ($row['langid'] == $_GET['langid']) {
			$pref = $row;
		} else if ($pref == null) {
			$pref = $row;
		}
	}
	return $pref;
}

function queryDocLink($did, $linktext) {
	$query = "SELECT doc_v.did, doc_v.linktext, doc_v.fid, doc_v.link, doc.module_signature, lang.langid, lang.flagtext, lang.flagpath, lang.priority ";
	$query .= "FROM doc_v, doc, lang WHERE doc.did='$did' AND lang.langid = doc_v.langid AND doc_v.did=doc.did ORDER BY priority DESC";
	$result = mysql_query($query);
	return createDocLink($result, $linktext); 
}

function createDocLink($result, $linktext) {
	$flags = "";
	$link = null;
	$means = null;
	while ($row = mysql_fetch_assoc($result)) {
		//fix link address:
		if ($row['module_signature'] == "regular") {
			$linkaddress = "'".xidlidPath("did", $did, $row['langid'])."'";
		} else if ($row['module_signature'] == "file") {
			$r = mysql_query("SELECT path FROM file WHERE fid = '".$row['fid']."'");
			$r = mysql_fetch_row($r);
			$linkaddress = "'".$r[0]."' TARGET='_blank'";
		} else if ($row['module_signature'] == "link") {
			$linkaddress = "'".$row['link']."'";
		}
		//create link (if needed)
		if ($row['langid'] == $_GET['lid'] || ($row['langid'] == $_GET['langid'] && $means == "default") || $link == null) {
			if ($link == null) $means = "default";
			$link = "<A HREF=$linkaddress>".(($linktext == null)?$row['linktext']:$linktext)."</A>";
		}
		//add flag
		$flags .= "<A HREF=$linkaddress><IMG SRC='".$row['flagpath']."' CLASS='flag' ALT=\"".$row['flagtext']."\"></A>";
	}
	return $link . " ".$flags;
}

function querySingleCatLink($cid, $linktext) {
	$query = "SELECT cat_v.cid, cat_v.linktext, lang.langid, flagtext, lang.flagpath, lang.priority ";
	$query .= "FROM cat_v, lang WHERE cid='$cid' AND lang.langid = cat_v.langid ORDER BY priority DESC";
	$result = mysql_query($query);
	return createSingleCatLink($result, $cid, $linktext);
}

function createSingleCatLink($result, $cid, $linktext) {
	$flags = "";
	$link = null;
	$means = null;
	while ($row = mysql_fetch_assoc($result)) {
		if ($cid != $row['cid']) {
			return $link." ".$flags;
		}
		$linkaddress = xidlidPath("cid", $cid, $row['langid']);
		if ($row['langid'] == $_GET['lid'] || ($row['langid'] == $_GET['langid'] && $means == "default") || $link == null) {
			if ($link == null) $means = "default";
			$link = "<A HREF='".$linkaddress."'>".(($linktext == null)?$row['linktext']:$linktext)."</A>";
		}
		$flags .= "<A HREF='".$linkaddress."'><IMG SRC='".$row['flagpath']."' CLASS='flag' ALT=\"".$row['flagtext']."\"></A>";
	}
	return $link . " ".$flags;
}

/* ------------------------------------ FUNCTIONS FOR PRINTING SIMPLE SELECTBOXES -------------------------------------------------------------------------- */
function selectBox($query, $name, $size, $default) {
	if ($res = mysql_query($query)) {
		$toReturn = "<SELECT NAME='$name' size=$size>";
		while ($row = mysql_fetch_row($res)) {
			$toReturn .= "<OPTION VALUE=\"".$row[0]."\"";
			if ($default == null || $default == $row[0]) {
				$toReturn .= " SELECTED";
				$default = -99;
			}
			$toReturn .= ">".$row[1]."</OPTION>\n";
		}
		$toReturn .= "</SELECT>";
	}
	return $toReturn;
}

function headerSelectBox($header, $query, $name, $size, $default) {
	if ($res = mysql_query($query)) {
		$toReturn = "<SELECT NAME='$name' size=$size>";
		$toReturn .= "<OPTION VALUE='-999'";
		if ($default == null) $toReturn .= " SELECTED";
		$toReturn .= ">$header</OPTION>";
		while ($row = mysql_fetch_row($res)) {
			$toReturn .= "<OPTION VALUE=\"".$row[0]."\"";
			if ($default == $row[0]) {
				$toReturn .= " SELECTED";
			}
			$toReturn .= ">".$row[1]."</OPTION>\n";
		}
		$toReturn .= "</SELECT>";
	}
	return $toReturn;
}

function selectLanguage($name, $size, $default) {
	$query = "SELECT langid, lname FROM lang ORDER BY lname";
	return selectBox($query, $name, $size, $default);
}

function selectFile($name, $size, $default) {
	$query = "SELECT fid, ident FROM file ORDER BY ident";
	return selectBox($query, $name, $size, $default);
}

function selectLayoutTemplate($name, $size, $default) {
        $query = "SELECT lid, layoutname FROM layout_template ORDER BY layoutname";
        return selectBox($query, $name, $size, $default);
}

/* ---------------------------------------- FUNCTIONS FOR PRINTING SELECTBOXES WITH SEVERAL LANGUAGE VERSIONS -------------------------------------------- */
/* creates a select box with the result from the given query 
 * if $default == null first result will be selected
 */
function uniqueSelectBoxDefault($query, $uniqueOn, $name, $size, $default) {
	$num = null;
	if ($res = mysql_query($query)) {
		$toReturn = "<SELECT NAME='$name' size=$size>";
		while ($row = mysql_fetch_row($res)) {
			if ($num == $row[$uniqueOn]) {
				continue;
			} else {
				$toReturn .= "<OPTION VALUE=\"".$row[0]."\"";
				if ($default == null || $default == $row[0]) {
					$toReturn .= " SELECTED";
					$default = -1;
				}
				$toReturn .= ">".$row[1]."</OPTION>\n";
				$num = $row[$uniqueOn];
			}
		}
		$toReturn .= "</SELECT>";
	}
	return $toReturn;
}

function uniqueSelectBox($query, $uniqueOn, $name, $size) {
	return uniqueSelectBoxDefault($query, $uniqueOn, $name, $size, null);
}

/* prints all types */
function selectImage($name, $size, $default) {
	$sql = "SELECT iid, ident FROM images ORDER BY ident ASC";
	return selectBox($sql, $name, $size, $default);
}

/* prints all types */
function selectType($name, $size, $default) {
	$sql = "SELECT tid, ident FROM dtype ORDER BY ident ASC";
	return selectBox($sql, $name, $size, $default);
}

/* prints all supporters */
function selectSupporter($name, $size, $default) {
	$sql = "SELECT sid, fullname FROM supporters ORDER BY fullname ASC";
	return selectBox($sql, $name, $size, $default);
}

/* prints all types */
function selectSpecialText($name, $size, $default) {
	$sql = "SELECT DISTINCT category, category FROM special_text ORDER BY category ASC";
	return selectBox($sql, $name, $size, $default);
}

/* prints all documents */
function selectDocument($header, $name, $size, $default) {
	// $sql = "SELECT did, ident FROM doc ORDER BY ident ASC";
// 	if ($header != null) {
// 		return headerSelectBox($header, $sql, $name, $size, $default);
// 	} else {
// 		return selectBox($sql, $name, $size, $default);
	//}
	$query = "SELECT did, dtype.ident as tident, doc.ident FROM doc, dtype WHERE typeid = tid ORDER BY tident, ident";
	return selectTypeNameList($query, $header, $name, $size, $default);
}

function selectIndex($header, $name, $size) {
	$sql = "SELECT did, dtype.ident as tident,doc.ident FROM doc, dtype WHERE tid = typeid AND typeid = 0";
	$sql .= " ORDER BY tident, ident ASC";
	return selectTypeNameList($sql, $header, $name, $size, null);
}

function selectParent($header, $name, $size, $id) {
	$sql = "SELECT hierarchy.parent, dtype.ident as tident,doc.ident FROM hierarchy, doc, dtype WHERE ";
	$sql .= " doc.did = hierarchy.parent AND hierarchy.did = $id AND tid=typeid ";
	$sql .= " ORDER BY tident,doc.ident ASC";
	return selectTypeNameList($sql, $header, $name, $size, null);
}

function selectChild($header, $name, $size, $id) {
	$sql = "SELECT doc.did, dtype.ident as tident, doc.ident FROM hierarchy, doc, dtype WHERE ";
	$sql .= "doc.did = hierarchy.did AND hierarchy.parent = $id AND tid=typeid ";
	$sql .= " ORDER BY tident,doc.ident ASC";
	return selectTypeNameList($sql, $header, $name, $size, null);
}

function selectTypeNameList($query, $header, $name, $size, $default) {
	if ($res = mysql_query($query)) {
		$toReturn = "<SELECT NAME='$name' size=$size>";
		if ($header != null) {
			$toReturn .= "<OPTION VALUE='-999'";
			if ($default == null) $toReturn .= " SELECTED";
			$toReturn .= ">$header</OPTION>";
		}
		while ($row = mysql_fetch_row($res)) {
			$toReturn .= "<OPTION VALUE=\"".$row[0]."\"";
			if ($default == $row[0]) {
				$toReturn .= " SELECTED";
			}
			$toReturn .= ">".strtoupper($row[1]).": ".$row[2]."</OPTION>\n";
		}
		$toReturn .= "</SELECT>";
	}
	return $toReturn;
}

function selectMapping($name, $size, $default) {
	$sql = "SELECT mid, ident, path FROM mapping, doc";
	$sql .= " WHERE mapping.did = doc.did ORDER BY path ASC";

	if ($res = mysql_query($sql)) {
		$toReturn = "<SELECT NAME='$name' size=$size>";
		while ($row = mysql_fetch_row($res)) {
			$toReturn .= "<OPTION VALUE=\"".$row[0]."\"";
			if ($default == null || $default == $row[0]) {
				$toReturn .= " SELECTED";
				$default = -1;
			}
			$toReturn .= ">".$row[2]."-->".$row[1]."</OPTION>\n";
		}
		$toReturn .= "</SELECT>";
	}
	return $toReturn;
}

?>
