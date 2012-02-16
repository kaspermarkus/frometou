<?php
require_once("general_purpose.php");

function get_index_array() {
	global $props, $_SESSION;
	$query = "SELECT doc.did, lang.lang, lang.flagtext, doc.description_img, doc_general_v.description, doc_general_v.linktext, dtype.tid, doc.module_signature, thumbnail_path ";
	$query .= "FROM doc, doc_general_v, dtype, lang, hierarchy ";
	$query .= "WHERE hierarchy.parent = '".$props['did']."' AND doc.did = hierarchy.did AND dtype.tid = doc.typeid ";
	$query .= "AND doc_general_v.did = doc.did AND doc_general_v.lang = lang.lang ";
	$query .= "ORDER BY dtype.priority DESC, doc.priority DESC, doc.did ASC, lang.priority DESC";
	$result = mysql_query($query);
	$index;
	while ($row = mysql_fetch_assoc($result)) {
		//save translation of document:
		$index[$row['tid']][$row['did']][$row['lang']] = $row;
		//if we find the correct language, use it
		if ((!isset($index[$row['tid']][$row['did']]['main'])) || ($row['lang'] == $_SESSION['lang'])) {
			$index[$row['tid']][$row['did']]['main'] = $row;
		}
	}
	return $index;
}

function generate_simple_index($show_types = true) {
	global $SHOW_PAGE_TRANSLATIONS, $SITE_INFO_PUBLIC_ROOT;
	$types = getTypes();
	$index = get_index_array();
	//now that we have all the links create a string with the html for the index:
	$html = "<ul>";
	foreach ($index as $typeid=>$docs) {
		if ($show_types) 
			$html .= "<li class='listingTypeHeader'>".$types[$typeid]."</li><ul>\n";
		
		foreach ($docs as $doc_id=>$doc) {
			$html .= "<LI CLASS='listingTypeLink'>";
			$html .= "<a href=\"".pageLink($doc_id, $doc['main']['lang'])."\">";
			$html .= $doc['main']['linktext']."</A>";
			if ($SHOW_PAGE_TRANSLATIONS) {
				foreach ($doc as $lang=>$version) {
					if ($lang != "main" && $lang != $_SESSION['lang']) {
						$html .= "<a href=\"". pageLink($doc_id, $version['lang'])."\">";
						$html .= "<img src=\"".$SITE_INFO_PUBLIC_ROOT.$version['thumbnail_path']."\" class='linkflags'/>";
						$html .= "</a>";	
					}
				}
			}
			$html .= "</li>";
		}
		if ($show_types) 
			$html .= "</UL>";
	}
	$html .= "</UL>";
	return $html;
}

function generate_descriptive_index() {
	global $SHOW_PAGE_TRANSLATIONS, $SITE_INFO_PUBLIC_ROOT;
	$types = getTypes();
	$index = get_index_array();
	//now that we have all the links create a string with the html for the index:
	$html = "<TABLE CLASS='listingDescriptionFlags'>";
	foreach ($index as $typeid=>$docs) {
		foreach ($docs as $doc_id=>$doc) {
			if ($SHOW_PAGE_TRANSLATIONS) {
				$flag_html="";
				foreach ($doc as $lang=>$version) {
					if ($lang != "main" && $lang != $_SESSION['lang']) {
						$flag_html .= "<a href=\"". pageLink($doc_id, $version['lang'])."\">";
						$flag_html .= "<img src=\"".$SITE_INFO_PUBLIC_ROOT.$version['thumbnail_path']."\" class='linkflags'/>";
						$flag_html .= "</a>";	
					}
				}
			}
			$html .= "<tr><th align='left'>";
			$html .= "<a href=\"".pageLink($doc_id, $doc['main']['lang'])."\">".$doc['main']['linktext']."</A>";
			$html .= $flag_html."</th>";
			$html .= "<th>(".$types[$typeid].")</th></tr>\n";
			$html .= "<TR><TD WIDTH=100% VALIGN='top'>".$doc['main']['description']."</TD>";
			if ($doc['main']['description_img']) {
				$html .= "<td><IMG SRC='".$SITE_INFO_PUBLIC_ROOT.$doc['main']['description_img']."' CLASS='listingDescriptionFlagsImg'></td>";
			} else {
				$html .= "<td><IMG SRC='".$SITE_INFO_PUBLIC_ROOT."imgs/no_img.svg' CLASS='listingDescriptionFlagsImg'></td>";

			}
			$html .= "</TR>";
		}
	}
	$html .= "</table>";
	return $html;
}

