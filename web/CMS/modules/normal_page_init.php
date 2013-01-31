<?php
//Ensure we have the required entry in the module table
ensure_module("normal_page", "Regular Page", "modules/normal_page.php", "modules/normal_page.php", "page");
ensure_module_props("normal_page_header", "normal_page", "Header");
ensure_module_props("normal_page_post_header", "normal_page", "Post Header");
ensure_module_props("normal_page_body_content", "normal_page", "Body");
?>	