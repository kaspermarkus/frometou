<?php

function rmNewlines($str) {
	$str = trim($str);
	//$str = $str.replace(System.Environment.NewLine, "");
	$str = eregi_replace("\n", "", $str); //linebreak
	$str = eregi_replace("\r", "", $str);
	$str = preg_replace('!([\S\t ]+).!', "\\1", $str.".\n");
	$str = trim($str);
	return $str;
}

function fixQuotes($str) {
	//set " -> &quot;
	while (preg_match('!([^<]+)(")([^>]+<|[^>]+$)!', $str)) {
		$str = preg_replace('!([^<]+)(")([^>]+<|[^>]+$)!', "\\1&quot;\\3", $str);
	}
	$str = preg_replace('!^"!', '&quot;', $str); //remove if starting with "
	$str = preg_replace('!"$!', '&quot;', $str); //remove if ending with "

	//set ' -> &#39;
	while (preg_match("!([^<]+)(')([^>]+<|[^>]+$)!", $str)) {
		$str = preg_replace("!([^<]+)(')([^>]+<|[^>]+$)!", "\\1&#39;\\3", $str);
	}
	$str = preg_replace("!^'!", '&#39;', $str); //remove if starting with ' 
	$str = preg_replace("!'$!", '&#39;', $str); //remove if ending with '

	//erstat til sidst alle " med '
	$str = eregi_replace('"', "'", $str);
	return $str;
}

function saveImages($str) {
	global $SITE_INFO_PUBLIC_ROOT;
	$regexp = "\\'($SITE_INFO_PUBLIC_ROOT(images/s_[0-9]+\.[a-z][a-z][a-z][a-z]?))";
	while (eregi($regexp, $str, $values)) {
		/* find entry in database */
		$result = mysql_query("SELECT iid FROM images WHERE small='".$values[2]."'");
		if ($row = mysql_fetch_row($result)) {
			$str = str_replace($values[1], $row[0], $str);
		}
	}
	return $str;
}

function readImages($str) {
	global $SITE_INFO_PUBLIC_ROOT;
	$regexp = "<img src='([0-9]+)'";
	while (eregi($regexp, $str, $values)) {
		$result = mysql_query("SELECT small FROM images WHERE iid='".$values[1]."'");
		if ($row = mysql_fetch_row($result)) {
			$str = str_replace($values[0], "<img src='$SITE_INFO_PUBLIC_ROOT$row[0]'", $str);
		}
	} 
	return $str;
}
?>