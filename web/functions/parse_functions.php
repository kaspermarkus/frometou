<?php
require_once("system/mandatory.php");
require_once("macros.php");

function parse_html($did, $body) {
	$body=stripslashes($body);
	$body = run_html_macros($body);

	global $SITE_INFO_PUBLIC_ROOT;
	/** FIX LINKS **/
	$regexp = "<a href='(\-?[0-9]+)'>";
	while (eregi($regexp, $body, $values)) {
		$query = "SELECT doc.did, doc.module_signature ";
		$query .= "FROM doc, lang, doc_general_v ";
		$query .= "WHERE doc.did = '".$values[1]."' AND doc.did = doc_general_v.did "; $query .= "AND lang.lang = doc_general_v.lang ";
		$query .= "ORDER BY lang.priority DESC";
		//echo $query;
		$result = mysql_query($query);
		while ($row = mysql_fetch_assoc($result)) {
			if ($row['module_signature'] == 'file') {
				$query = "SELECT path FROM file WHERE fid = '".$row['fid']."'";
				$r = mysql_fetch_row(mysql_query($query));
				$linkaddress = "<A HREF='".$SITE_INFO_PUBLIC_ROOT.$r[0]."' TARGET='_blank'";
			} else {
				if ($row['module_signature'] == 'link') {
					$linkaddress = $row['link'];
				} else {
					$linkaddress = pageLink($row['did'], $row['lang']);
				}
				$linkaddress = "<A HREF='$linkaddress'";
			}

			if ($row['lang'] == $_GET['tmplang'] || ($row['lang'] == $_SESSION['lang'] && $means == "default") || $link == null) {
				if ($link == null) $means = "default";
				$link = $linkaddress.">";
			}
		}
		//echo "REPLACING STRING: $values[0] WITH $link<HR>";
		$body = str_replace($values[0], $link, $body);
	}
	return $body;
}
?>
