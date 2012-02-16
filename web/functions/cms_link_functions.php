<?php
function generate_direct_cms_link() {
	global $props, $SITE_INFO_PUBLIC_ROOT;
	$html = "<a href=\"${SITE_INFO_PUBLIC_ROOT}CMS/editDocs.php?did=".$props['did']."\">edit</a>";
	return $html;
}

?>
