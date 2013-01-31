<?php

class normal_page {
	var $props = [];
	var $did;

	function init($did, $lang) {
		$query = "SELECT * FROM doc_module_v as dmv, module_props as mp ".
			"WHERE dmv.prop_signature = mp.signature AND dmv.did=$did ".
			"AND dmv.langid=$lang AND mp.module_signature='normal_page'";
		$result = mysql_query($query);
		if ($result && mysql_num_rows($result) > 0) {
			while ($row = mysql_fetch_assoc($result)) {
				$this->props[$row['prop_signature']] = $row['value'];
			}
			 // print_r($this->props);
		}
	}
	
	function get($key) {
		return (isset($this->props[$key])) ? $this->props[$key] : "";
	}

	function printHTMLForm() {
		echo "<table><TR><TH>header:</TH><TD><input size='50' name='normal_page_header' value=\"".
		$this->get('normal_page_header')."\"></TD></TR>".
		"<TR><TH>post header:</TH><TD><input size='50' name='normal_page_post_header' value=\"".
		$this->get('normal_page_post_header')."\"></TD></TR>".
		"<TR><TH>Body:</TH><TD>".
		"<textarea name='normal_page_body_content'>".
		$this->get('normal_page_body_content').
		"</textarea>".
		"<script type='txt/javascript' src='ckeditor/ckeditor_source.js'></script>".
		"<script language='JavaScript' type='text/javascript'>".
		"    CKEDITOR.replace( 'normal_page_body_content' , {toolbar : 'MyToolbar', ".
		"		filebrowserBrowseUrl: 'kfm/'});".
		"</script></td><table>";
	}

	function single_save($lang, $did, $sig, $val) {
	    $query = "REPLACE doc_module_v ( `did` , `prop_signature` , `langid` , `value`) VALUES ".
	    	"( '$did', \"$sig\", '$lang', \"$val\")";
	    //echo $query."<br/>";
		mysql_query($query);
	}

	function save($post, $lang) {
		$did = $post['did'];
		$this->single_save($lang, $did, "normal_page_header", $post["normal_page_header"]);
		$this->single_save($lang, $did, "normal_page_post_header", $post["normal_page_post_header"]);
		$body = fix_html_field($post["normal_page_body_content"]);
		$this->single_save($lang, $did, "normal_page_body_content", $body);
	}

	function delete($lang) {
	    $query = "DELETE FROM doc_module_v WHERE did='$did' AND langid='$lang'";
		mysql_query($query);
	}
}