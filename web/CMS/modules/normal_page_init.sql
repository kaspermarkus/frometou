/* Register the module with the signature normal_page */
INSERT INTO frometou_db.module ( mid, module_signature, module_name, display_path, cms_path) VALUES ( NULL , 'normal_page', 'Normal Page', 'modules/normal_page.php', 'modules/normal_page.php');

/* Then initialize the fields the CMS user is able to edit */
INSERT INTO module_text (prop_id, module_signature, signature, property_name, input_type, shown, priority) VALUES (NULL, 'normal_page', 'header', 'Header', 'text', '1', '300');
INSERT INTO module_text (prop_id, module_signature, signature, property_name, input_type, shown, priority) VALUES (NULL, 'normal_page', 'post_header', 'Post Header', 'text', '1', '200');
INSERT INTO module_text (prop_id, module_signature, signature, property_name, input_type, shown, priority) VALUES (NULL, 'normal_page', 'body', 'Body', 'html', '1', '100');


