<?php
require_once("general_purpose.php");
require_once("index_functions.php");

function run_html_macros($body) {
	$body = macro_simple_index($body);
	$body = macro_type_index($body);
	$body = macro_descriptive_index($body);
	return $body;
}

function macro_simple_index($body) {
    $signature = "@@index:simple@@"; 
	if (preg_match("/$signature/", $body)) {
		$html = generate_simple_index(false);
		$body = str_ireplace($signature, $html, $body);
	}
	return $body;
}
function macro_type_index($body) {
    $signature = "@@index:categorized@@"; 
	if (preg_match("/$signature/", $body)) {
		$html = generate_simple_index(true);
		$body = str_ireplace($signature, $html, $body);
	}
	return $body;
}

function macro_descriptive_index($body) {
	$signature = "@@index:descriptive@@"; 
 	if (preg_match("/$signature/", $body)) {
		$html = generate_descriptive_index();
		$body = str_ireplace($signature, $html, $body);
	}
	return $body;
}

