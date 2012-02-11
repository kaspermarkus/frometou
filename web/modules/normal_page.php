<?php
$fields = $props['normal_page'];

//TODO: Include modules
if (isset($fields['header'])) echo "<H1 CLASS='docheader'>".$fields['header']."</H1>";
if (isset($fields['post_header'])) echo "<H2 CLASS='docheader'>".$fields['post_header']."</H2>";
echo fixBody($_GET['did'], $fields['body']);

?>
