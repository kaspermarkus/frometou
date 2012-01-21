<?php
//retrieve filename of layout to use..
$query = "SELECT lid, filename FROM layout, layout_template WHERE layout.layout_used = layout_template.lid";
$result = mysql_query($query);
if (!$result) {
	echo "Serious error occured: $query";
} 
$result = mysql_fetch_assoc($result);
include("$SITE_INFO_LOCALROOT".$result['filename']);

?>
