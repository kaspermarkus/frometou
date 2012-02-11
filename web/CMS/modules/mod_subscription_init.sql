/* Register the module */
INSERT INTO frometou_db.module ( mid, module_signature, module_name, display_path, cms_path) VALUES ( NULL , 'mod_subscription', 'Subscription Form', 'modules/mod_subscription.php', 'modules/mod_subscription_cms.php');

/* Register the module text fields */
INSERT INTO module_text (prop_id, module_signature, signature, property_name, input_type, shown, priority) VALUES (NULL, 'mod_subscription', 'header', 'Header', 'text', '1', '670');
INSERT INTO module_text (prop_id, module_signature, signature, property_name, input_type, shown, priority) VALUES (NULL, 'mod_subscription', 'post_header', 'Post Header', 'text', '1', '360');
INSERT INTO module_text (prop_id, module_signature, signature, property_name, input_type, shown, priority) VALUES (NULL, 'mod_subscription', 'text_before_form', 'Text Before Form', 'html', '1', '350');
INSERT INTO module_text (prop_id, module_signature, signature, property_name, input_type, shown, priority) VALUES (NULL, 'mod_subscription', 'form_header', 'Form Header', 'text', '1', '345');
INSERT INTO module_text (prop_id, module_signature, signature, property_name, input_type, shown, priority) VALUES (NULL, 'mod_subscription', 'fullname', 'Fullname Label', 'text', '1', '340');
INSERT INTO module_text (prop_id, module_signature, signature, property_name, input_type, shown, priority) VALUES (NULL, 'mod_subscription', 'email', 'Email Address Label', 'text', '1', '335');
INSERT INTO module_text (prop_id, module_signature, signature, property_name, input_type, shown, priority) VALUES (NULL, 'mod_subscription', 'submit_button_text', 'Text on Submit Button', 'text', '1', '330');
INSERT INTO module_text (prop_id, module_signature, signature, property_name, input_type, shown, priority) VALUES (NULL, 'mod_subscription', 'reset_button_text', 'Text on Reset Button', 'text', '1', '325');
INSERT INTO module_text (prop_id, module_signature, signature, property_name, input_type, shown, priority) VALUES (NULL, 'mod_subscription', 'text_after_form', 'Text After Form', 'html', '1', '320');
INSERT INTO module_text (prop_id, module_signature, signature, property_name, input_type, shown, priority) VALUES (NULL, 'mod_subscription', 'success_text', 'Text displayed after subscription is made', 'html', '2', '315');
INSERT INTO module_text (prop_id, module_signature, signature, property_name, input_type, shown, priority) VALUES (NULL, 'mod_subscription', 'email_subject', 'Text for email subject line', 'text', '2', '310');
INSERT INTO module_text (prop_id, module_signature, signature, property_name, input_type, shown, priority) VALUES (NULL, 'mod_subscription', 'email_body', 'The message that should go in the email', 'html', '2', '305');
