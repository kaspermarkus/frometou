<?php
function insert_page_translations($imgs = false) {
	global $SITE_INFO_PUBLIC_ROOT;
	global $_SESSION;
	$query = "SELECT thumbnail_path, lang.id as lang, lname FROM lang, defaultlangs WHERE defaultlangs.langid = lang.id ORDER BY lang.priority DESC";
	$result = mysql_query($query);
	while ($row = mysql_fetch_assoc($result)) {
		$imgsrc = $SITE_INFO_PUBLIC_ROOT.$row['thumbnail_path'];
	//	echo $_SESSION['lang']." vs ".$row['lang'];
        	if ($_SESSION['lang'] != $row['lang']) {
			if ($imgs) {
                		echo "<A HREF='".changeLangLink($row['lang'])."'><img src=\"$imgsrc\" CLASS='defaultflags-regular'></A> ";
			} else {
		                echo "<A HREF='".changeLangLink($row['lang'])."' CLASS='NE_FLAGS'>".$row['lname']."</A> ";
			}
        	} else {
			if ($imgs) {
                		echo "<img src=\"$imgsrc\" CLASS='defaultflags-selected' /> ";
			} else {
		                echo "<B>".$row['lname']."</B> ";
			}
                }
        }
}
?>