<?php
require_once($SITE_INFO_LOCAL_ROOT."functions/parse_functions.php");
$fields = $props['normal_page'];

//print_r($fields);
if (isset($fields['header'])) echo "<H1 CLASS='docheader'>".$fields['header']."</H1>";
if (isset($fields['post_header'])) echo "<H2 CLASS='docheader'>".$fields['post_header']."</H2>";
echo parse_html($_GET['did'], isset($fields['body_content'])?$fields['body_content']:"");

?>
