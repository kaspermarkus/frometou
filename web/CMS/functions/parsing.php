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
?>
