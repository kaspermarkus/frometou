<?php
require_once($SITE_INFO_LOCAL_ROOT."functions/parse_functions.php");

//get data:
$fields = [];

$query = "SELECT * FROM doc_module_v as dmv, module_props as mp ".
    "WHERE dmv.prop_signature = mp.signature AND dmv.did=".$props->get("did")." ".
    "AND dmv.langid='".$props->get('lang')."' AND mp.module_signature='normal_page'";

$result = mysql_query($query);
if ($result && mysql_num_rows($result) > 0) {
    while ($row = mysql_fetch_assoc($result)) {
        $fields[$row['prop_signature']] = $row['value'];
    }
}

if (isset($fields['normal_page_header'])) echo "<H1 CLASS='docheader'>".$fields['normal_page_header']."</H1>";
if (isset($fields['normal_page_post_header'])) echo "<H2 CLASS='docheader'>".$fields['normal_page_post_header']."</H2>";
echo parse_html($_GET['did'], isset($fields['normal_page_body_content'])?$fields['normal_page_body_content']:"");

?>
