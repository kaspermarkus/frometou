<?php
function generate_direct_cms_link() {
	global $props, $SITE_INFO_PUBLIC_ROOT;
	$html = "<br><br><br><a href=\"${SITE_INFO_PUBLIC_ROOT}CMS/doc_edit.php?did=".$props->get('did')."\">edit</a>";
	return $html;
}
?>
