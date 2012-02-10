<?php
require_once("authorize.php");
//header('Content-Type: text/html; charset=utf-8');

$_POST['did'] = $_GET['did'];	

//To be used if a regular document is shown
function showModuleForm() {
	$module_signature = "contact_form";
	$id='did'; 
	//get translation specific regular document info
 	if (isset($_POST[$id])) {
		$formquery = "SELECT * FROM contact_form_v WHERE did=".$_POST['did']." AND lang_id=".$_SESSION['langid']." ORDER BY priority DESC"; 
		//$query .= "FROM doc_module_v as v, doc_module_property as p WHERE p.prop_id = v.prop_id AND did=".$_POST['did']." AND lang_id=".$_SESSION['langid']." ORDER BY priority DESC";*/
		//echo $formquery;
		$result = mysql_query($formquery);
		global $prop;
                if (mysql_num_rows($result) > 0) {
                        foreach (mysql_fetch_assoc($result) as $var=>$value) {
                                $prop[$var] = $value;
                        }
                }   
	}
?>
<h3>Contact Form Settings</h3>
 <TABLE>                         
        <TR><TH>Text Before Form: </TH><TD COLSPAN="2"><textarea cols="100" rows="8"  name="text_before"><?php echo $prop['text_before'] ?></textarea></TD></TR>
        <TR><TH>Full Name: </TH><TD COLSPAN="2"><input TYPE='text' size="80" name="full_name" value="<?php echo $prop['full_name'] ?>"></TD></TR>
        <TR><TH>Street: </TH><TD COLSPAN="2"><input TYPE='text' size="80" name="street" value="<?php echo $prop['street'] ?>"></TD></TR>
        <TR><TH>City: </TH><TD COLSPAN="2"><input TYPE='text' size="80" name="city" value="<?php echo $prop['city'] ?>"></TD></TR>
        <TR><TH>Zip: </TH><TD COLSPAN="2"><input TYPE='text' size="80" name="zip" value="<?php echo $prop['zip'] ?>"></TD></TR>
        <TR><TH>Country: </TH><TD COLSPAN="2"><input TYPE='text' size="80" name="country" value="<?php echo $prop['country'] ?>"></TD></TR>
        <TR><TH>Comment: </TH><TD COLSPAN="2"><textarea cols="100" rows="8"  name="comment"><?php echo $prop['comment'] ?></textarea></TD></TR>
        <TR><TH>Text After Form: </TH><TD COLSPAN="2"><textarea cols="100" rows="8"  name="text_before"><?php echo $prop['text_before'] ?></textarea></TD></TR>
	<TR><TH COLSPAN=2 style="text-align:left;">
           <INPUT TYPE="submit" value="Save Form" name="saveModule">
	</TH></TR>
	</TABLE>
	<?php
}

function saveModuleForm() {
	print_r($_POST);
   global $id;
$query = "INSERT INTO contact_form_v ( did, lang_id, text_before, full_name, street, zip, city, country, comment, text_after) VALUES ";
$query .= "( ".$_POST['did'].", ".$_SESSION['langid'].", \"".$_POST['text_before']."\", \"".$_POST['full_name']."\", \"".$_POST['street']."\", \"".$_POST['zip']."\" ";
$query .= "\"".$_POST['city']."\", \"".$_POST['country']."\",\"".$_POST['comment']."\", \"".$_POST['text_after']."\" )";
        echo $query;
        mysql_query($query);
        //header("location:$filename?$id=".$_POST[$id]);
}

?>
