<?php
require_once("functions.php");

/* insert flags on the page to change the current language. Used when editing pages, etc. */
function cms_insert_flags($id, $postid) {
	global $SITE_INFO_PUBLIC_ROOT, $SITE_INFO_LANGS_ENABLED;
	//only show flags if we have multiple languages enabled for website. This is a setting in siteInfo.php
	if ($SITE_INFO_LANGS_ENABLED) {
		/* -------------- fix flags ------------------------------------ */
		$mysql = "SELECT id, thumbnail_path FROM lang ORDER BY priority DESC";
		$result = mysql_query($mysql);
		//echo $mysql;
		while ($row = mysql_fetch_assoc($result)) {
			if ($row['id'] == $_SESSION['lang']) {
				echo "<IMG SRC='".$SITE_INFO_PUBLIC_ROOT.$row['thumbnail_path']."' WIDTH='44' HEIGHT='30'>&nbsp;";
			} else {
				echo "<A HREF='?";
				if (isset($postid)) {
					echo "$id=$postid&";
				}
				echo "lang=".$row['id']."'><IMG SRC='".$SITE_INFO_PUBLIC_ROOT.$row['thumbnail_path']."' WIDTH='22' HEIGHT='15' BORDER=0></A>&nbsp;";
			}
 		}
	}
}

?>
