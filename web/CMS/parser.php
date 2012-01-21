<?php
require_once("path.php");
require_once("functions.php");

function parser($txt) {
	$parsedtxt = "\n".$txt;
	$parsedtxt = eregi_replace("\n", "<BR>\n", $parsedtxt); //linebreak
	$parsedtxt = eregi_replace("[-]{4,}", "<HR>\n", $parsedtxt); //horisontal line
	$parsedtxt = eregi_replace("\*\*([^\*\*]*)\*\*", "<B>\\1</B>", $parsedtxt); //bold font
	$parsedtxt = eregi_replace("//([^//]*)//", "<I>\\1</I>", $parsedtxt); //italic
	$parsedtxt = eregi_replace("__([^//]*)__", "<U>\\1</U>", $parsedtxt); //underline
	$parsedtxt = eregi_replace("\n!!!([^\n]*)<BR>\n", "\n<H1>\\1</H1>\n", $parsedtxt); //H1
	$parsedtxt = eregi_replace("\n!!([^\n]*)<BR>\n", "\n<H2>\\1</H2>\n", $parsedtxt); //H2
	$parsedtxt = eregi_replace("\n!([^\n]*)<BR>\n", "\n<H3>\\1</H3>\n", $parsedtxt); //H3
	$parsedtxt = fixIndent($parsedtxt);
	$parsedtxt = fixItemize($parsedtxt);
	$parsedtxt = fixImages($parsedtxt);
	$parsedtxt = fixLinks($parsedtxt);
	echo $parsedtxt;

}

function fixLinks($txt) {
	$line = strtok($txt, "\n");
	$regex = "\#L[ ]([^ \#]+)( [^\#]*)?\#";
	do {
		while (eregi($regex, $line, $match)) {
			$arr = spliti($regex, $line, 2);
			$ret .= $arr[0];
			$linktext = $match[2];
			$linkaddress = $match[1];
			
			//check for internal link;
			if (eregi("^(D|C)([0-9]+)$", $linkaddress, $submatch)) {
				if ($submatch[1] == "D") { 
					$ret .= queryDocLink($submatch[2], $linktext);
				} else if ($submatch[1] == "C") {
					$ret .= queryCatLink($submatch[2], $linktext);
				}
			} //check for external link:
			else if (preg_match('!^((ftp|http[s]?)://)?(\.?([a-z0-9-]+))+\.[a-z]{2,6}(:[0-9]{1,5})?(/[a-zA-Z0-9.,;\?|\'+&%\$#=~_-]+)*$!i', $linkaddress, $submatch)) {
				if (preg_match('!^(ftp|http[s]?)://!i', $submatch[1])) {
					$ret .= "<A HREF=\"".$submatch[0]."\">".$linktext."</A>";
				} else {
					$ret .= "<A HREF=\"http://".$submatch[0]."\">".$linktext."</A>";
				}
			}
			$line = $arr[1];
		}
		$ret .= $line."\n";
	} while (($line = strtok("\n")) !== false);
	return $ret;
}

function fixImages($txt) {
	$line = strtok($txt, "\n");
	$regex = "\#G[ ]([0-9]+)( [WHA]=[0-9LR]+)*\#";
	do {
		while (eregi($regex, $line, $match)) {
			$arr = spliti($regex, $line, 2);
			$ret .= $arr[0];
			$result = mysql_query("SELECT small, big FROM images WHERE iid='$match[1]'");
			if ($row = mysql_fetch_row($result)) {
				$img = "";
				//check if we need to link image to a bigger version: */
				if ($row[1]!="") $img .= "<A HREF='".xidPath("iid", "$match[1]")."'>";
				$img .= "<IMG SRC='".$row[0]."' BORDER=0".fixLinkParams($match[0]);
				//check for alttext:
				$alt = getTranslation("SELECT langid, alt FROM images_v WHERE iid = $match[1]");
				if ($alt != null) {
					$img .= " ALT='".$alt['alt']."'";
				}
				$img .= ">";
				if ($row[1]!="") $img .= "</A>";
				$ret .= $img;
			} else {
				$ret .= substr($line, 0, strlen($arr[0]));;
			}
			$line = $arr[1];
		}
		$ret .= $line."\n";
	} while (($line = strtok("\n")) !== false);
	return $ret;
}

function fixLinkParams($txt) {
	if (eregi("W=([0-9]+)", $txt, $match)) 
		$return .= " WIDTH='".$match[1]."'";
	if (eregi("H=([0-9]+)", $txt, $match)) 
		$return .= " WIDTH='".$match[1]."'";
	if (eregi("A=([LR])", $txt, $match))
		$return .= " ALIGN='".((strcasecmp($match[1], "R")?"RIGHT":"LEFT"))."'";
	return $return;
}


function fixIndent($txt) {
	$line = strtok($txt, "\n");
	$ret = "";
	$indenting = false;
	do {
		if (ereg("^\t", $line) == true) {
			if ($indenting == false) {
				$ret .= "<BLOCKQUOTE>";
				$indenting = true;
			} 
			$ret .= eregi_replace("^\t", "", $line)."\n";
		} else {
			if ($indenting == true) {
				$ret .= "</BLOCKQUOTE>\n";
				$indenting = false;
			}
			$ret .= $line."\n";
		}
	} while (($line = strtok("\n")) !== false);
	return $ret;
}

function fixItemize($txt) {
	$line = strtok($txt, "\n");
	$ret = "";
	$itemizing = false;
	do {
		if (ereg("^\*", $line) == true) {
			if ($itemizing == false) {
				$ret .= "<UL>";
				$itemizing = true;
			} 
			$line = eregi_replace("^\*", "<LI>", $line)."\n";
			$ret .= eregi_replace("<BR>$", "</LI>", $line)."\n";
		} else {
			if ($itemizing == true) {
				$ret .= "</UL>\n";
				$itemizing = false;
			}
			$ret .= $line."\n";
		}
	} while (($line = strtok("\n")) !== false);
	return $ret;
}

?>

<HTML>
<BODY>
<?php parser($test); ?>
</BODY>
</HTML>
