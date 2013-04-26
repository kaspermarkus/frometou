<?php
class normal_page {
    var $props = [];

    function load($did, $lang) {
        $this->did = $did;
        $query = "SELECT * FROM doc_module_v as dmv, module_props as mp ".
            "WHERE dmv.prop_signature = mp.signature AND dmv.did=$did ".
            "AND dmv.langid='$lang' AND mp.module_signature='normal_page'";
        $result = mysql_query($query);
        if ($result && mysql_num_rows($result) > 0) {
            while ($row = mysql_fetch_assoc($result)) {
                $this->props[$row['prop_signature']] = $row['value'];
            }
        } else {
            $this->props = [];
        }
    }
    
    function get($key) {
        return (isset($this->props[$key])) ? $this->props[$key] : "";
    }

    function printEditArea() {
        ?>
        <table>
            <tr>
                <th>header:</th>
                <td><input size='50' name='normal_page_header' value="<?php echo $this->get('normal_page_header'); ?>"></td>
            </tr>
            <tr>
            	<th>post header:</th>
            	<td><input size='50' name='normal_page_post_header' value="<?php echo $this->get('normal_page_post_header'); ?>"></td>
            </tr>
        	<tr>
        		<th>Body:</th>
        		<td>
        			<textarea name='normal_page_body_content'><?php echo $this->get('normal_page_body_content'); ?></textarea>
					<script type='txt/javascript' src='lib/ckeditor/ckeditor_source.js'></script>
					<script language='JavaScript' type='text/javascript'>
        				CKEDITOR.replace('normal_page_body_content' , 
        					{toolbar : 'MyToolbar', filebrowserBrowseUrl: 'lib/elFinder/elfinder.html', uiColor: '#9AB8F3'});
    				</script>
				</td>
			</tr>
		</table>
		<?php
    }

    function single_save($lang, $did, $sig, $val) {
        $query = "REPLACE doc_module_v ( `did` , `module`, `prop_signature` , `langid` , `value`) VALUES ".
            "( '$did', 'normal_page', \"$sig\", '$lang', \"$val\")";
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

    function delete() {
        mysql_query("DELETE FROM doc_module_v WHERE module='normal_page' AND did='$this->did'");
    }

    function deleteLang($langid) {
        //echo "DELETE FROM doc_module_v WHERE module='normal_page' AND did='$this->did' AND langid='$langid'";
        mysql_query("DELETE FROM doc_module_v WHERE module='normal_page' AND did='$this->did' AND langid='$langid'");
    }
}
?>