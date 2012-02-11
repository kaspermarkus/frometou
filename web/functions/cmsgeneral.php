<?php

function cms_insert_flags($id, $postid) {
	global $SITE_INFO_PUBLIC_ROOT;
	/* -------------- fix flags ------------------------------------ */
	$mysql = "SELECT langid, thumbnail_path FROM lang ORDER BY priority DESC";
	$result = mysql_query($mysql);

	while ($r = mysql_fetch_assoc($result)) {
		if ($r['langid'] == $_SESSION['langid']) {
			echo "<IMG SRC='".$SITE_INFO_PUBLIC_ROOT.$r['thumbnail_path']."' WIDTH='44' HEIGHT='30'>&nbsp;";
		} else {
			echo "<A HREF='?";
			if (isset($postid)) {
				echo "$id=$postid&";
			}
			echo "langid=".$r['langid']."'><IMG SRC='".$SITE_INFO_PUBLIC_ROOT.$r['thumbnail_path']."' WIDTH='22' HEIGHT='15' BORDER=0></A>&nbsp;";
		}
 	}
}

?>
