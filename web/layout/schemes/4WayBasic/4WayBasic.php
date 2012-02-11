<?php

function leftMenu() {
	return;
	global $SITE_INFO_PUBLIC_ROOT;
	$types = getTypes();

	$query = "SELECT doc.did, lang.shorthand, doc_general_v.linktext, doc.format FROM doc, doc_general_v, lang, hierarchy ";
	$query .= "WHERE hierarchy.parent = '0' AND doc.did = hierarchy.did AND doc.did = doc_general_v.did AND lang.langid = doc_general_v.langid ";
	$query .= "AND lang.shorthand = '".$_GET['lang']."' ";
	$query .= "ORDER BY doc.priority DESC, doc.did ASC, lang.priority DESC";
	$result = mysql_query($query);
	$prevRow;
	$out = "<TABLE CLASS='leftmenu-table'>";
	$out .= "<TR><TD CLASS='leftmenu-spacer'><TABLE CLASS='leftmenu-spacer'><TR><TD CLASS='dots'></TD></TR></TABLE></TD></TR>\n";
	if (mysql_num_rows($result) != null) {
		while ($row = mysql_fetch_assoc($result)) {
			if ($link != null) {
				$out .= "<TR><TD CLASS='leftmenu-links'><IMG SRC='/layout/schemes/basic1/arrow.gif'>".$link."</TD></TR>\n";
				$out .= "<TR><TD CLASS='leftmenu-spacer'><TABLE CLASS='leftmenu-spacer'><TR><TD CLASS='dots'></TD></TR></TABLE></TD></TR>\n";
			}
			if ($row['format'] == 'file') {
				$r = mysql_fetch_row(mysql_query("SELECT path FROM file WHERE fid = '".$row['fid']."'"));
				$linkaddress = "<A HREF='".$SITE_INFO_PUBLIC_ROOT.$r[0]."' TARGET='_blank' CLASS='leftmenu-links'>";
			} else {
				if ($row['format'] == 'link') {
					$linkaddress = $row['link'];
				} else {
					$linkaddress = pageLink($row['did'], null, null);
				}
				$linkaddress = "<A HREF='$linkaddress' CLASS='leftmenu-links'>";
			}
			$link = $linkaddress.$row['linktext']."</A>";
		}
	}
	if ($link != null) {
		$out .= "<TR><TD CLASS='leftmenu-links'><IMG SRC='/layout/schemes/basic1/arrow.gif'>".$link."</TD></TR>\n";
		$out .= "<TR><TD CLASS='leftmenu-spacer'><TABLE CLASS='leftmenu-spacer'><TR><TD CLASS='dots'></TD></TR></TABLE></TD></TR>\n";
	}
	$out .= "</TABLE>";
	return $out;
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
<LINK REL="stylesheet" type="text/css" href="<?php echo $SITE_INFO_PUBLIC_ROOT; ?>layout/schemes/basic1/basic1.css" />
</head>
<body class="body">
<center>
<BR>

<table cellpadding="0" cellspacing="0" bgcolor="white">
<tr>
  <td class="outherTableTopLeft" width="30" height="30">
  </td>
  <td class="outherTableTopCenter" height="30">
  </td>
  <td class="outherTableTopRight" width="30" height="30">
  </td>
</tr>
<tr>
<td class="outherTableCenterLeft" width="30px">
</td>
<td>


<table CLASS='maintable' cellpadding="0" cellspacing="0">
  <tbody>
	<tr>
		<td CLASS='topLang' colspan="3">
			<TABLE WIDTH=100%>
			  <TR><TD CLASS='NE_FLAGS'><?php echo $defaultflags; ?></TD></TD></TR>
			  <TR><TD CLASS='NE_BOTTOM'></TD></TR>
			</TABLE>
		</td>
	</tr>
	<tr>
		<td CLASS='maintableTopMain' colspan="3"><br><br><br><br><br>
			<H1>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Fundamentalism</H1>
		 </td>
    </tr>
    <tr>	 
        <td CLASS='maintableLeft'>
			<BR>
			 <?php echo leftMenu(); ?>
		 </td>
		 <td CLASS='maintableMain'>
			<?php
				
			require_once($SITE_INFO_LOCALROOT.$props['normal_page']['display_path']);
			echo "<BR>";

			/* SUBSCRIBE PAGE */
			if ($_GET['did'] == -1) {
				echo "<BR><h1>asdfdsafdsafdsafdsafdsagasd";
				echo "<TABLE WIDTH='100%'><TR><TD CLASS='translations'>Other languages: $translations</TD></TR></TABLE>";
				require_once("subscribe.php");
			/* List of supporters */
			}else if ($_GET['did'] == -2) {
				echo "<TABLE WIDTH='100%'><TR><TD CLASS='translations'>Other languages: $translations</TD></TR></TABLE>";
				echo "<BR>";
				require_once("supportlist.php");
			/* NOTIFY FRIEND */
			 } else if ($_GET['did'] == -4) {
				echo "<TABLE WIDTH='100%'><TR><TD CLASS='translations'>Other languages: $translations</TD></TR></TABLE>";
				echo "<BR>";
				require_once("notifyfriend.php");
			/* FORWARD APPEAL */
			 } else if ($_GET['did'] == -6) {
				echo "<TABLE WIDTH='100%'><TR><TD CLASS='translations'>Other languages: $translations</TD></TR></TABLE>";
				echo "<BR>";
				require_once("forwardappeal.php");
			 }			
			?>
		</td>
		<TD CLASS="maintableRight">
			<?php
			//then the right frame, as can be edited by users
			$query = "SELECT body FROM doc_regular_v, lang ";
			$query .= "WHERE doc_regular_v.langid = lang.langid AND lang.shorthand = '".$_GET['lang']."' AND did=-5 ";
			$rightframe = mysql_fetch_row(mysql_query($query));
			echo fixBody(-5, $rightframe[0]);
			//echo $rightframe[0];
			?>			
		</TD>
	</tr>
  <tbody>
</table>

</td>
<td class="outherTableCenterRight" width="30px">
</td>
</tr>
<tr>
<td class="outherTableBottomLeft" width="30px" height="30">
</td>
<td class="outherTableBottomCenter" height="30">
</td>
<td class="outherTableBottomRight" width="30px" height="30">
</td>
</tr>
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
//		if ($_GET['lang'] != $row['shorthand']) {
//			$defaultflags .= "<A HREF='".pageLink(null, $row['shorthand'], null)."'>$img CLASS='defaultflags-regular'></A>";
//		} else {
//			$defaultflags .= "$img CLASS='defaultflags-selected'>";
//		}
//	}
//}

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
//$query .= "WHERE doc_v.langid = lang.langid AND lang.shorthand = '".$_GET['lang']."' AND did=-5 ";
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
