<?php
function show_form() {
	global $props;
	$fields = $props['mod_subscription'];
	if (isset($fields['header'])) echo "<H1 CLASS='docheader'>".$fields['header']."</H1>";
	if (isset($fields['post_header'])) echo "<H2 CLASS='docheader'>".$fields['post_header']."</H2>";

	echo fixBody($_GET['did'], $fields['text_before_form']);

	//print_r($fields);
	//print preform text if any:
	?>

	<FIELDSET><LEGEND><B><?php echo $fields['form_header']; ?>:</B></LEGEND>
	<FORM NAME='subscribeform' METHOD='post'>
	<TABLE>
	<TR><TH ALIGN='left'><?php echo $fields['fullname']; ?>:</TH><TD WIDTH=100%><INPUT TYPE='text' VALUE='' NAME='fullname' SIZE=40>*</TD></TR>
	<TR><TH ALIGN='left'><?php echo $fields['email']; ?>:</TH><TD><INPUT TYPE='text' VALUE='' NAME='email' SIZE=40></TD></TR>
	<TR><TD COLSPAN=2>
	</TD></TR>
	<TR><TH></TH><TD><INPUT TYPE='submit' VALUE='<?php echo $fields["submit_button_text"]; ?>' NAME='submit'> <INPUT TYPE='reset' VALUE='<?php echo $fields["reset_button_text"]; ?>'></TD></TR>
	</TABLE>
	</FIELDSET>
	</FORM>
<?php
	echo fixBody($_GET['did'], $fields['text_after_form']);
}

function show_success_msg() {
	global $props;
	$fields = $props['mod_subscription'];
        if (isset($fields['header'])) echo "<H1 CLASS='docheader'>".$fields['header']."</H1>";
        if (isset($fields['post_header'])) echo "<H2 CLASS='docheader'>".$fields['post_header']."</H2>";

        echo fixBody($_GET['did'], $fields['success_text']);
}
if (isset($_GET['success'])) {
	show_success_msg();
} else if (!isset($_POST['submit'])) {
	show_form();
} else if (isset($_POST['submit'])) {
	global $props;
	$fields = $pros['mod_subscription'];
	/* fix mails / signup etc */
	if (isset($_POST['submit'])) {
		foreach ($_POST as $ind=>$val) {
			$val = strip_tags($val);
			$val = str_replace("'", "`", $val);
			$val = str_replace('"', "`", $val);
			$val = substr($val, 0, min(strlen($val), 3000));
			$val = trim($val);
			$_POST[$ind] = $val;
		}
	
		/* check for required fields */
		if ($_POST['fullname'] == "") {
			$errormsg .= "Please enter a name<BR><BR>";
		} 
		if (!ereg("[^ ]+ [^ ]+", $_POST['fullname']))  {
			$errormsg .= "Please enter a valid name<BR><BR>";
		}
		if ($_POST['email'] == "") {
			$errormsg .= "You have to enter an email address <BR><BR>";
		}
		if ($errormsg != "") {
			echo $errormsg;
			$errormsg .= "Please correct the above errors before proceeding<BR><BR>";
			show_form();
		} else {
			/* fix mail for subscribee */
			$to = $_POST['fullname']." <".$_POST['email'].">";
			$from = "From: The Jens Galschiøt - Fundamentalism <aidoh@aidoh.dk>"; 
			$subject = $fields['email_subject'];
			$message = $fields['email_body'];
			$headers = "MIME-Version: 1.0\r\n";     
			$headers .= "$from\r\n";     
			echo "SENDING MAIL: to ".$to.".........".$subject.$message.$headers;
			mail($to, $subject, $message, $headers); //Sender mailen 
			header("location:?success=true");	
			echo "My page".pageLink($_GET['did'], null, null)."?success=true";
			/* lksdjkjldfskjldfsasdfkl 
			$to = "kasper2@markus.dk"; 
			$subject = "New subscription"; //Emnefeltet
			$message = "New subscription made by:\r\n";
			$message .= "fullname: ".$_POST['fullname']."\r\n";
			$message .= "email: ".$_POST['email']."\r\n";
			$header  = "MIME-Version: 1.0" . "\r\n";
			$header .= "from:aidoh@aidoh.dk";
			mail($to, $subject, $message, $header); //Send!! */
		}
	}
}
?>
