<?php
require_once("authorize.php");
//header('Content-Type: text/html; charset=utf-8');

$_POST['did'] = $_GET['did'];	

showModuleForm();
//To be used if a regular document is shown
function showModuleForm() {
	$id='did'; 
	echo "<DIV id='clickme'>ikasper</DIV>";
	echo "<TABLE id='moduleTable'>";
	//get translation specific regular document info
 	if (isset($_POST[$id])) {
		$query = "SELECT v.prop_id, property_name, input_type, value, shown ";
		$query .= "FROM doc_module_v as v, doc_module_property as p WHERE p.prop_id = v.prop_id AND did=".$_POST['did']." AND lang_id=".$_SESSION['langid']." ORDER BY priority DESC";
		$result = mysql_query($query);
		if (mysql_num_rows($result) > 0) {
			while ($row = mysql_fetch_assoc($result)) {
				echo utf8_encode("<TR><TH>".$row['property_name']."</TH><TD>");
				echo utf8_encode("    <TD><input TYPE='checkbox' CLASS='visibilityToggler' NAME='shown_".$row['prop_id']."' VALUE='".$row['prop_id']."' ".(($row['shown']==1)?"CHECKED":"")." /></TD>");
				if ($row['input_type'] == 'text') {
					echo utf8_encode("<input TYPE='text' size='80' name='".$row['prop_id']."' id='inputfield".$row['prop_id']."' value=\"".$row['value']."\" ".(($row['shown']==0)?"style='display:none;'":"")." />");
				} else if ($row['input_type'] == 'boolean') {
					echo utf8_encode("<input type='checkbox' value='1' NAME='".$row['prop_id']."' CHECKED='".(($row['value'] == 1)?"yes":"no")."'>");
				} else if ($row['input_type'] == 'html') {
					echo utf8_encode("<TEXTAREA NAME='".$row['prop_id']."' COLS=80 ROWS=3 id='inputfield".$row['prop_id']."' ".(($row['shown']==0)?"style='display:none;'":"").">".$row['value']."</TEXTAREA>");
				}
				echo "</TD></TR>";

			}
			//$prop['body'] = fixQuotes($prop['body']);
			//$prop['body'] = readImages($prop['body']);
		}
	}
	?>
	<TR><TH COLSPAN=2 style="text-align:left;">
           <INPUT TYPE="submit" value="save" name="saveModule">
	</TH></TR>
	</TABLE>
	<?php
}
?>
