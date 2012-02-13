<?php

function leftMenu() {
	global $SITE_INFO_PUBLIC_ROOT;
	$types = getTypes();
	$query = "SELECT doc.did, lang.shorthand, doc_general_v.linktext FROM doc, doc_general_v, lang, hierarchy ";
	$query .= "WHERE hierarchy.parent = '0' AND doc.did = hierarchy.did AND doc.did = doc_general_v.did AND lang.langid = doc_general_v.langid ";
	$query .= "AND lang.shorthand = '".$_SESSION['lang']."' ";
	$query .= "ORDER BY doc.priority DESC, doc.did ASC, lang.priority DESC";
	//echo $query;
	$result = mysql_query($query);
	$prevRow;
	$link = null;
	$out = "<TABLE CLASS='leftmenu-table'>";
	$out .= "<TR><TD CLASS='leftmenu-spacer'><TABLE CLASS='leftmenu-spacer'><TR><TD CLASS='dots'></TD></TR></TABLE></TD></TR>\n";
	while ($row = mysql_fetch_assoc($result)) {
		if ($link != null) {
			$out .= "<TR><TD CLASS='leftmenu-links'><IMG SRC='/layout/schemes/basic1/arrow.gif'>".$link."</TD></TR>\n";
			$out .= "<TR><TD CLASS='leftmenu-spacer'><TABLE CLASS='leftmenu-spacer'><TR><TD CLASS='dots'></TD></TR></TABLE></TD></TR>\n";
		}
		$linkaddress = pageLink($row['did'], null, null);
		$linkaddress = "<A HREF='$linkaddress' CLASS='leftmenu-links'>";
		$link = $linkaddress.$row['linktext']."</A>";
	}
	if ($link != null) {
		$out .= "<TR><TD CLASS='leftmenu-links'><IMG SRC='/layout/schemes/basic1/arrow.gif'>".$link."</TD></TR>\n";
		$out .= "<TR><TD CLASS='leftmenu-spacer'><TABLE CLASS='leftmenu-spacer'><TR><TD CLASS='dots'></TD></TR></TABLE></TD></TR>\n";
	}
	$out .= "</TABLE>";
	return $out;
}
function insert_page_translations($imgs = false) {
	global $SITE_INFO_PUBLIC_ROOT;
	$query = "SELECT thumbnail_path, lang.langid, shorthand, lname FROM lang, defaultlangs WHERE defaultlangs.langid = lang.langid ORDER BY lang.priority DESC";
	$result = mysql_query($query);
	while ($row = mysql_fetch_assoc($result)) {
		$imgsrc = $SITE_INFO_PUBLIC_ROOT.$row['thumbnail_path'];
        
        	if ($_SESSION['lang'] != $row['shorthand']) {
			if ($imgs) {
                		echo "<A HREF='".pageLink(null, $row['shorthand'], null)."'><img src=\"$imgsrc\" CLASS='defaultflags-regular'></A>";
			} else {
		                echo "<A HREF='".pageLink(null, $row['shorthand'], null)."' CLASS='NE_FLAGS'>".$row['lname']."</A>";
			}
        	} else {
			if ($imgs) {
                		echo "<img src=\"$imgsrc\" CLASS='defaultflags-selected' />";
			} else {
		                echo "<B><A HREF='".pageLink(null, $row['shorthand'], null)."' CLASS='NE_FLAGS'>".$row['lname']."</A></B>";
			}
                }
        }
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<HTML>
<HEAD>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1"/> 
<meta http-equiv="Content-Language" content="el">
<TITLE>
<?php echo $pagetitle; ?>
</TITLE>
<link rel="icon" href="<?php echo $SITE_INFO_PUBLIC_ROOT; ?>favicon.ico" type="image/x-icon" />
<?php 
include_once("basic1.css.php");
?>
</head>
<body>
<center>
<BR><BR><table CLASS='maintable' cellpadding="0" cellspacing="0">
  <tbody>
    <tr>
       <td CLASS='maintableTopLeft'>
        <IMG CLASS='maintableTopLeft' SRC="<?php echo $SITE_INFO_PUBLIC_ROOT; ?>layout/schemes/basic1/logo.png" /> 
	</td>
       <td CLASS='maintableTopMain'>
	<?php 
	if ($SITE_INFO_LANGS_ENABLED) {
		insert_page_translations();
	}
	?>
         <H1>frometou</H1>
	 <H3>Simple website building</H3>
	</td>
    </tr>
    <tr>	 
        <td CLASS='maintableLeft'>
	<BR>
	 <?php echo leftMenu(); ?>
	 </td>
	 <td CLASS='maintableMain'>
<?php
//if $SHOW_PAGE_TRANSLATION is true, show flags for the different translations of the document:
if ($SITE_INFO_LANGS_ENABLED && $SHOW_PAGE_TRANSLATIONS) {
//Create flag to other versions of the document
        //print_r($props['translations']);
	echo '<div class="translation_flags">';
	foreach ($props['translations'] as $langid=>$trans) {
        	if ($props['shorthand'] != $trans['shorthand']) {
                	echo "<A HREF='".pageLink(null, null, $trans['shorthand'])."'>";
			echo "<IMG CLASS='translation_flags' SRC=\"".$SITE_INFO_PUBLIC_ROOT.$trans['thumbnail_path']."\">";       
			echo "</A>";
        	}
	}	 
	echo '</div>';
}
?>
<?php
//fire up the modules part
require_once($SITE_INFO_LOCALROOT.$props['normal_page']['display_path']);
?>
	</td>
	</tr>
	<tr>
	 <td CLASS='maintableBottom' colspan="2">
	 Colette Markus / Overgade 14, 2.th. / 5000 Odense C / tlf: 2126 5257 / e-mail: <a href="mailto:colette@markus.dk">colette@markus.dk</a>
	 </td>
	</tr>
  <tbody>
</table>
<?php
//if (isset($header)) echo "<H1 CLASS='docheader'>$header</H1>";
//if (isset($postheader)) echo "<H2 CLASS='docheader'>$postheader</H2>";
//echo "<HR>";
//if ($_GET['did'] < 0) {
//	$query = "SELECT lang.langid, lang.shorthand, images.iid, images.small, lang.lname FROM lang, defaultlangs, images WHERE defaultlangs.langid = lang.langid AND";
//	$query .= " images.iid = lang.iid ORDER BY lang.priority DESC";
//	$result = mysql_query($query);
//	$defaultflags = "";
//	while ($row = mysql_fetch_assoc($result)) {
//		$img = "<IMG SRC='".$SITE_INFO_PUBLIC_ROOT.$row['small']."'";	
//		
//		if ($_SESSION['lang'] != $row['shorthand']) {
//			$defaultflags .= "<A HREF='".pageLink(null, $row['shorthand'], null)."'>$img CLASS='defaultflags-regular'></A>";
//		} else {
//			$defaultflags .= "$img CLASS='defaultflags-selected'>";
//		}
//	}
//}
///* SUBSCRIBE PAGE */
//if ($_GET['did'] == -1) {
//	echo "<TABLE WIDTH='100%'><TR><TD CLASS='translations'>Other languages: $translations</TD></TR></TABLE>";
//	echo "<BR>";
//	require_once("subscribe.php");
///* SUPPORT PAGE */
// } else if ($_GET['did'] == -2) {
//	echo "<TABLE WIDTH='100%'><TR><TD CLASS='translations'>Other languages: $translations</TD></TR></TABLE>";
//	echo "<BR>";
//	require_once("supportlist.php");
//
///* NOTIFY FRIEND */
// } else if ($_GET['did'] == -4) {
//	echo "<TABLE WIDTH='100%'><TR><TD CLASS='translations'>Other languages: $translations</TD></TR></TABLE>";
//	echo "<BR>";
//	require_once("notifyfriend.php");
//
///* FORWARD APPEAL */
// } else if ($_GET['did'] == -6) {
//	echo "<TABLE WIDTH='100%'><TR><TD CLASS='translations'>Other languages: $translations</TD></TR></TABLE>";
//	echo "<BR>";
//	require_once("forwardappeal.php");
///* SUBSCRIPTION CHANGES */
// } else if ($_GET['did'] == -7) {
//	echo "<BR>";
//	require_once("maillist.php");
///* SUPPORT PAGE */
// } else if ($_GET['did'] == -8) {
//	echo "<TABLE WIDTH='100%'><TR><TD CLASS='translations'>Other languages: $translations</TD></TR></TABLE>";
//	echo "<BR>";
//	require_once("followuplist.php");
///* SUPPORT PAGE */
// } else if ($_GET['did'] == -9) {
//	echo "<TABLE WIDTH='100%'><TR><TD CLASS='translations'>Other languages: $translations</TD></TR></TABLE>";
//	echo "<BR>";
//	require_once("followup-signup.php");
// 
///* REGULAR DOCUMENT */
// } else {
//	if ($translations != "") { 
//		echo "<TABLE WIDTH='100%'><TR><TD CLASS='translations'>Other languages: $translations</TD></TR></TABLE>";
//	}
////	echo $body;
// }
//
//if ($parents[0] != "") {
//	echo "<HR>";
//	echo "<H3>Back to:</H3>";
//	echo "<UL>";
//	foreach ($parents as $v) {
//		echo "<LI>$v</LI>";
//	}
//	echo "</UL>";
// }
//?>
<?php //
//	  </TD>
//	  <TD CLASS='E'>
//		<TABLE WIDTH=100%>
//		  <TR><TD CLASS='E_TOP'></TD></TR>
//          <TR><TD CLASS='E_BOTTOM'>
//	
//  <?php
///* ----------- RIGHT FRAME ---------- */
////SIDSTE FIL ER DEN NYESTE!!!
////load contents of the right frame
////firstly have the flash-slideshow
//  $slideshowfile;
//  if ($handle = opendir($SITE_INFO_LOCALROOT."files/")) {
//    while (false !== ($file = readdir($handle))) {
//      
//      if (($pos = strpos($file, "swf")) === false) {
//      } else {
// 	$slideshowfile = $file;
//      }
//    }
//    closedir($handle);
//  }
 //<center>
 //<object width="160" height="128">
//    <param name="movie" value=<?php echo "'".$SITE_INFO_PUBLIC_ROOT."files/".$slideshowfile."'"; 
?>
<?php //>
  //<embed src=<?php echo "'".$SITE_INFO_PUBLIC_ROOT."files/".$slideshowfile."'"; ?> <?php //width="160" height="128">
  //</center>
//<HR>
//
//<?php
////then the right frame, as can be edited by users
//$query = "SELECT body FROM doc_v, lang ";
//$query .= "WHERE doc_v.langid = lang.langid AND lang.shorthand = '".$_SESSION['lang']."' AND did=-5 ";
//$rightframe = mysql_fetch_row(mysql_query($query));
//echo fixBody($_GET['did'], $rightframe[0]);
//
///* finally print the counter */
//$query = "SELECT countervalue FROM counter WHERE countertype='daily'";
//$res = mysql_fetch_row(mysql_query($query));
//$counter = $res[0];
//if ($counter < 1000) {
//	$counter = "000$counter";
//} else if ($counter < 10000) {
//	$counter = "00$counter";
//} else if ($counter < 100000) {
//	$counter = "0$counter";
//}
//echo "<HR><DIV CLASS='counter'><TABLE CLASS='counter'><TR><TD CLASS='counter'>$counter</TD></TR></TABLE>";
//echo "<FONT CLASS='counter'>visits since Jan. 2008</FONT></DIV>";
//?>  
<?php  //	</TD></TR>
//
//
//		</TABLE>
//	  </TD>
//	</TR>
//	  
//	</tbody>
//</table>?>
</center>
</BODY>
</HTML>
