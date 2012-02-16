<?php
require_once($SITE_INFO_LOCAL_ROOT."functions/general_purpose.php");
require_once($SITE_INFO_LOCAL_ROOT."functions/cms_link_functions.php");

function leftMenu() {
	global $SITE_INFO_PUBLIC_ROOT;
	$types = getTypes();
	$query = "SELECT doc.did, doc_general_v.linktext FROM doc, doc_general_v, lang, hierarchy ";
	$query .= "WHERE hierarchy.parent = '0' AND doc.did = hierarchy.did AND doc.did = doc_general_v.did AND lang.lang = doc_general_v.lang ";
	$query .= "AND lang.lang = '".$_SESSION['lang']."' ";
	$query .= "ORDER BY doc.priority DESC, doc.did ASC, lang.priority DESC";
	//echo $query;
	$result = mysql_query($query);
	$prevRow;
	$link = null;
	$out = "<TABLE CLASS='leftmenu-table'>";
	$out .= "<TR><TD CLASS='leftmenu-spacer'><TABLE CLASS='leftmenu-spacer'><TR><TD CLASS='dots'></TD></TR></TABLE></TD></TR>\n";
	while ($row = mysql_fetch_assoc($result)) {
		if ($link != null) {
			$out .= "<TR><TD CLASS='leftmenu-links'><IMG SRC='${SITE_INFO_PUBLIC_ROOT}imgs/arrow.gif'>".$link."</TD></TR>\n";
			$out .= "<TR><TD CLASS='leftmenu-spacer'><TABLE CLASS='leftmenu-spacer'><TR><TD CLASS='dots'></TD></TR></TABLE></TD></TR>\n";
		}
		$linkaddress = pageLink($row['did']);
		$linkaddress = "<A HREF='$linkaddress' CLASS='leftmenu-links'>";
		$link = $linkaddress.$row['linktext']."</A>";
	}
	if ($link != null) {
		$out .= "<TR><TD CLASS='leftmenu-links'><IMG SRC='${SITE_INFO_PUBLIC_ROOT}imgs/arrow.gif'>".$link."</TD></TR>\n";
		$out .= "<TR><TD CLASS='leftmenu-spacer'><TABLE CLASS='leftmenu-spacer'><TR><TD CLASS='dots'></TD></TR></TABLE></TD></TR>\n";
	}
	$out .= "</TABLE>";
	return $out;
}
function insert_page_translations($imgs = false) {
	global $SITE_INFO_PUBLIC_ROOT;
	global $_SESSION;
	$query = "SELECT thumbnail_path, lang.lang, lname FROM lang, defaultlangs WHERE defaultlangs.lang = lang.lang ORDER BY lang.priority DESC";
	$result = mysql_query($query);
	while ($row = mysql_fetch_assoc($result)) {
		$imgsrc = $SITE_INFO_PUBLIC_ROOT.$row['thumbnail_path'];
	//	echo $_SESSION['lang']." vs ".$row['lang'];
        	if ($_SESSION['lang'] != $row['lang']) {
			if ($imgs) {
                		echo "<A HREF='".changeLangLink($row['lang'])."'><img src=\"$imgsrc\" CLASS='defaultflags-regular'></A>";
			} else {
		                echo "<A HREF='".changeLangLink($row['lang'])."' CLASS='NE_FLAGS'>".$row['lname']."</A>";
			}
        	} else {
			if ($imgs) {
                		echo "<img src=\"$imgsrc\" CLASS='defaultflags-selected' />";
			} else {
		                echo "<B>".$row['lname']."</B>";
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
include_once("layout.css.php");
?>
</head>
<body>
<center>
<BR><BR><table CLASS='maintable' cellpadding="0" cellspacing="0">
  <tbody>
    <tr>
       <td CLASS='maintableTopLeft'>
        <IMG CLASS='maintableTopLeft' SRC="<?php echo $SITE_INFO_PUBLIC_ROOT; ?>imgs/logo.png" /> 
	</td>
       <td CLASS='maintableTopMain'>
	<?php 
	//print_r($_SESSION);
	if ($SITE_INFO_LANGS_ENABLED) {
		insert_page_translations();
	}
	?>
         <H1>frometou</H1>
	 <H3>Simple website building</H3>
	<p align="right"><?php echo generate_direct_cms_link(); ?></p>
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
	echo '<div class="linkflags">';
	foreach ($props['translations'] as $lang=>$trans) {
        	if ($props['lang'] != $lang) {
                	echo "<A HREF='".pageLink($_GET['did'], $lang)."'>";
			echo "<IMG CLASS='linkflags' SRC=\"".$SITE_INFO_PUBLIC_ROOT.$trans['thumbnail_path']."\">";       
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
	 <td CLASS='maintableBottom' COLSPAN=2>
	 Colette Markus / Overgade 14, 2.th. / 5000 Odense C / tlf: 2126 5257 / e-mail: <a href="mailto:colette@markus.dk">colette@markus.dk</a>
	 </td>
	</tr>
  <tbody>
</table>
</center>
</BODY>
</HTML>
