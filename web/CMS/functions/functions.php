<?php
/* ---------------------- MODULE INITIALISATION ------------------------- */
function ensure_module ($sig, $name, $display_path, $cms_path, $module_type) {
	$query = "REPLACE INTO module ( module_signature, module_name, display_path, cms_path, module_type, enabled ) "
		." VALUES ('$sig',  '$name',  '$display_path',  '$cms_path',  '$module_type', 1)";
	mysql_query($query);
}

function ensure_module_props ($sig, $mod_sig, $name) {
	$query = "REPLACE INTO module_props (signature, module_signature, property_name ) "
		." VALUES ('$sig', '$mod_sig', '$name' )";
	mysql_query($query);
}


/* ---------------------------------- FOR GETTING TRANSLATION ----------------------------------------------------------------------------------------------*/
function queryDocLink($did, $linktext) {
	$query = "SELECT doc_v.did, doc_v.linktext, doc_v.fid, doc_v.link, doc.module_signature, lang.langidid, lang.flagtext, lang.flagpath, lang.priority ";
	$query .= "FROM doc_v, doc, lang WHERE doc.did='$did' AND lang.langid = doc_v.lang AND doc_v.did=doc.did ORDER BY priority DESC";
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
			$linkaddress = "'".xidlidPath("did", $did, $row['lang'])."'";
		} else if ($row['module_signature'] == "file") {
			$r = mysql_query("SELECT path FROM file WHERE fid = '".$row['fid']."'");
			$r = mysql_fetch_row($r);
			$linkaddress = "'".$r[0]."' TARGET='_blank'";
		} else if ($row['module_signature'] == "link") {
			$linkaddress = "'".$row['link']."'";
		}
		//create link (if needed)
		if ($row['lang'] == $_GET['lid'] || ($row['lang'] == $_GET['lang'] && $means == "default") || $link == null) {
			if ($link == null) $means = "default";
			$link = "<A HREF=$linkaddress>".(($linktext == null)?$row['linktext']:$linktext)."</A>";
		}
		//add flag
		$flags .= "<A HREF=$linkaddress><IMG SRC='".$row['flagpath']."' CLASS='flag' ALT=\"".$row['flagtext']."\"></A>";
	}
	return $link . " ".$flags;
}

/* Multi query to printf string function */
function query_to_printf ($query, $str) {
	//get argument minus the first two we know
	$columns = func_get_args();
	array_shift($columns);
	array_shift($columns);
	//do query
	$result = mysql_query($query);
	if ($result && mysql_num_rows($result) > 0) {
		while ($row = mysql_fetch_assoc($result)) {
			$printfArgs = array ( $str );
			//go through the row and create an array of values of the required columns
			foreach ($columns as $key => $value) {
				array_push($printfArgs, $row[$value]);
			}
			call_user_func_array('printf', $printfArgs);
		}
	} else {
		return null;
	}
	return true;
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
	} else {
		die("invalid sql query: ".mysql_error());
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

/* prints all documents */
function selectDocument($header, $name, $size, $default) {
	$query = "SELECT did, doc.ident FROM doc ORDER BY ident";
	return selectTypeNameList($query, $header, $name, $size, $default);
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
			$toReturn .= ">".$row[1]."</OPTION>\n";
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
