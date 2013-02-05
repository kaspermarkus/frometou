<?php
class propContainer {
	var $data = [];

	function add($category, $query) {
		//echo $query;
		$result = mysql_query($query);
		if ($result && mysql_num_rows($result) > 0) {
			$prev = isset($this->data[$category]) ? $this->data[$category] : [];
			$this->data[$category] = array_merge($prev, mysql_fetch_assoc($result));
			//print_r($this->data);
			return true;
		}
		return false;
	}

	function get($key, $category="baseData") {
		return (isset($this->data[$category]) && isset($this->data[$category][$key])) ? $this->data[$category][$key] : NULL;
	}
	
	function __construct($did) {
		//get general properties:
		$query = "SELECT doc.did, lang.id as lang, doc.module_signature, lang.thumbnail_path, lang.lname, pagetitle, description, module.display_path ";
		$query .= "FROM doc, doc_general_v as general, lang, module ";
		$query .= "WHERE general.langid = lang.id AND doc.did='$did' AND doc.did = general.did AND doc.module_signature LIKE module.module_signature ";
		$query .= " ORDER BY lang.priority DESC";
		$result = mysql_query($query);
		
		$translations; //$translations[langname][id,lang,img] ordered list of available translations
		$module_props; //holds properties of the module
		$means = null; //saves how we decided on the language to use
		$langageUsed; //saves what language ended up being used
		
		while ($row = mysql_fetch_assoc($result)) {
			if (isset($_GET['tmplang']) && $row['lang'] == $_GET['tmplang']) { 
				//first priority is if user has chosen this document in a particular language (tmplang)
				$this->data["baseData"] = $row;
				$means = "tmplang";
				$languageUsed = $row["lang"];
			} else if ($row['lang'] == $_SESSION['lang'] && $means != 'tmplang') { 
				//if we haven't found a translation by direct choice (means != tmplang) then session is priority
				$this->data["baseData"] = $row;
				$means = 'lang';
				$languageUsed = $row["lang"];
			} else if ($means == null) {
				//default to highest priority language if no language is previously set
				$this->data["baseData"] = $row;
				$means = 'default';
				$languageUsed = $row["lang"];
			}
			$translations[$row['lang']]["thumbnail_path"] = $row['thumbnail_path'];
			$translations[$row['lang']]["lname"] = $row['lname'];
			$module_props["display_path"] = $row['display_path'];
			$module_signature = $row['module_signature'];
		}
		
		//finally, add all to props array and return
		$this->data["translations"]=$translations;
		$this->data["baseData"]["languageUsed"] = $languageUsed;
	}

}


// function getDocumentProperties($did) {
// 	$props;
// 	//get general properties:
// 	$query = "SELECT doc.did, lang.id as lang, doc.module_signature, lang.thumbnail_path, lang.lname, pagetitle, description, module.display_path ";
// 	$query .= "FROM doc, doc_general_v as general, lang, module ";
// 	$query .= "WHERE general.langid = lang.id AND doc.did='$did' AND doc.did = general.did AND doc.module_signature LIKE module.module_signature ";
// 	$query .= " ORDER BY lang.priority DESC";
// 	$result = mysql_query($query);
	
// 	$props; //Save the row for language used in $props
// 	$translations; //$translations[langname][id,lang,img] ordered list of available translations
// 	$module_props; //holds properties of the module
// 	$means = null; //saves how we decided on the language to use
	
// 	while ($row = mysql_fetch_assoc($result)) {
// 		if (isset($_GET['tmplang']) && $row['lang'] == $_GET['tmplang']) { 
// 			//first priority is if user has chosen this document in a particular language (tmplang)
// 			$props = $row;
// 			$means = "tmplang";
// 		} else if ($row['lang'] == $_SESSION['lang'] && $means != 'tmplang') { 
// 			//if we haven't found a translation by direct choice (means != tmplang) then session is priority
// 			$props = $row;
// 			$means = 'lang';
// 		} else if ($means == null) {
// 			//default to highest priority language if no language is previously set
// 			$props = $row;
// 			$means = 'default';
// 		}
// 		$translations[$row['lang']]["thumbnail_path"] = $row['thumbnail_path'];
// 		$translations[$row['lang']]["lname"] = $row['lname'];
// 		$module_props["display_path"] = $row['display_path'];
// 		$module_signature = $row['module_signature'];
// 	}
	
// 	//Module properties:
// 	$sql = "SELECT * FROM doc_module_v as tv, module_props as t WHERE tv.prop_signature LIKE t.signature AND t.module_signature LIKE '$module_signature' AND tv.did = '$did' AND lang='".$props['lang']."'";
// 	//echo $sql;  
// 	$result = mysql_query($sql); 
// 	if ($result) {
// 		while ($row = mysql_fetch_assoc($result)) {
// 			$module_props[$row['signature']] = $row['value'];
// 		}
// 	}
// 	//parents:
// 	$parents = getParents($did);
	
// 	//finally, add all to props array and return
// 	$props['did'] = $did;
// 	$props["parents"] = $parents;
// 	$props["translations"]=$translations;
// 	$props[$module_signature] = $module_props;
// 	//echo "FROM display";
// 	//print_r($props);
// 	return $props;
// }

// function getParents($did) {
// 	global $SITE_INFO_PUBLIC_ROOT;
// 	$query = "SELECT doc.did, lang.id as lang, lang.lname, doc_general_v.linktext ";
// 	$query .= "FROM doc_general_v, lang, doc, hierarchy ";
// 	$query .= "WHERE doc_general_v.langid = lang.id AND doc_general_v.did = doc.did AND hierarchy.parent = doc.did ";
// 	$query .= "AND hierarchy.did = '$did' ";
// 	$query .= " ORDER BY doc.priority DESC, doc.did ASC, lang.priority DESC";
// 	$result = mysql_query($query);
// 	$flags = "";
// 	$link = "";
// 	while ($row = mysql_fetch_assoc($result)) {
// 		if (isset($prevRow) && $row['did'] != $prevRow['did']) {
// 			$parents[] = $link . $flags;
// 			$flags = null;
// 			$means = null;
// 		}
// 		if ($row['lang'] == $_SESSION['lang']) {
// 			$link = "<A HREF='".pageLink($row['did'])."'>".$row['linktext']."</A>";
// 			$means = "lang";
// 		} else if ($means == null) {
// 			$link = "<A HREF='".pageLink($row['did'], $row['lang'])."'>".$row['linktext']."</A>";
// 			$means = 'default';
// 		}
// 		$flags .= "<A HREF='".pageLink($row['did'], $row['lang'])."'><IMG SRC='somepath'></A>"; //fixme .$SITE_INFO_PUBLIC_ROOT.$row['small']."' CLASS='linkflags'></A>";
// 		$prevRow = $row;
// 	}
// 	$parents[] = $link . $flags;
// 	return $parents;
// }
?>
