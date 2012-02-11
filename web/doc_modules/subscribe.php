 <?php
$query = "SELECT * FROM special_text as st, special_text_v as stv, lang WHERE st.stid = stv.stid AND st.category = 'subscribe' AND lang.langid = stv.langid AND lang.shorthand = '".(($_GET['tmplang']=='') ? $_GET['lang'] : $_GET['tmplang'])."'";
$result = mysql_query($query);
while ($row = mysql_fetch_assoc($result)) {
    $vars[$row['field']] = $row['value']; 
}

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
		echo "Please enter a name<BR><BR>";
	} 
	if (!ereg("[^ ]+ [^ ]+", $_POST['fullname']))  {
		$errormsg = "Please enter a valid name<BR><BR>";
	}
	if ($_POST['country'] == "") {
		$errormsg .= "You have to enter a country<BR><BR>";
	}
	if ($_POST['email'] == "") {
		$errormsg .= "You have to enter an email address <BR><BR>";
	}
	if ($errormsg != "") {
		$errormsg .= "Please correct the above errors before proceeding<BR><BR>";
	} else {
		if ($_POST['subscribe_check'] == "true") {
			/** fix mail for subscribee */
			$to = $_POST['fullname']." <".$_POST['email'].">";
			$from = "From: The Color Orange <info@thecolororange.net>"; 
			$subject = "Successfully subscribed to TheColorOrange mailing list"; //Mailens titel
			$message = "Welcome ".$_POST['fullname']."\r\n\r\n";
			$message .= "\tYou have successfully subscribed to the maillinglist of TheColorOrange.net.\r\n\r\n";
			$message .= "\tIf an error occured, or you for some reason wish to be removed from the maillinglist,";
			$message .= "please write so to info@thecolororange.net.";
			$headers = "MIME-Version: 1.0\r\n";     
			$headers .= "$from\r\n";     
			mail($to, $subject, $message, $headers); //Sender mailen 

			/** fix mail for ourself */
			$to = "info@thecolororange.net"; 
			$subject = "New subscription"; //Emnefeltet
			$message = "New subscription made by:\r\n";
			$message .= "fullname: ".$_POST['fullname']."\r\n";
			$message .= "street: ".$_POST['street']."\r\n";
			$message .= "city: ".$_POST['city']."\r\n";
			$message .= "postal: ".$_POST['postal']."\r\n";
			$message .= "country: ".$_POST['country']."\r\n";
			$message .= "email: ".$_POST['email']."\r\n";
			$message .= "comments: ".$_POST['comments']."\r\n";
			$header  = "MIME-Version: 1.0" . "\r\n";
			$header .= "from:info@thecolororange.net";
			mail($to, $subject, $message, $header); //Send!! 

			/** entry to DB */
			//strip for '" and ;
			$stripper = array( "'", '"', ";" );
			$query = "INSERT INTO maillist (ID, name, street, city, postal, country, email, comment) VALUES ( ";
			$query .= "'', '".str_replace($stripper, "", $_POST['fullname'])."', ";
			$query .= "'".str_replace($stripper, "", $_POST['street'])."', ";
			$query .= "'".str_replace($stripper, "", $_POST['city'])."', ";
			$query .= "'".str_replace($stripper, "", $_POST['postal'])."', ";
			$query .= "'".str_replace($stripper, "", $_POST['country'])."', ";
			$query .= "'".str_replace($stripper, "", $_POST['email'])."', ";
			$dbcomment = str_replace(array ( "\n", '<BR>'), array (". ", ". "), $_POST['comments']);
			$query .= "'".str_replace($stripper, "", $dbcomment)."')";
			mysql_query($query);
			//echo $query;
			$successmsg = "<H2>Welcome to TheColorOrange network</H2>";
			$successmsg .= "You have successfully been subscribed to the mailling list of TheColorOrange";
			$successmsg .= "<HR><BR>";
 		}
		/* ------------- SUPPORT LIST ------------------------- */
		if ($_POST['support_check'] == "true") {
			$query = "INSERT INTO supporters ( sid, fullname, city, country, comments, active ) VALUES ( ";
			$query .= " '', '".$_POST['fullname']."', '".$_POST['city']."', ";
			$query .= "'".$_POST['country']."'";
			if ($_POST['publish_comment'] == "true") {
				$query .= ", '".$_POST['comments']."'";
			} else {
				$query .= ", ''";
			}
			$query .= ", '0' )";
			mysql_query($query);
			$query = "SELECT sid, DATE_FORMAT(time, '%s%H%c%y%i%j') as time FROM supporters WHERE fullname='".$_POST['fullname']."' AND city='".$_POST['city']."' AND country='".$_POST['country']."' ORDER BY sid DESC";
			$result = mysql_query($query);
			$row = mysql_fetch_assoc($result);
			$to = $_POST['fullname']." <".$_POST['email'].">";
			$from = "From: The Color Orange <info@thecolororange.net>"; 
			$subject = "Confirm your support of TheColorOrange"; //Mailens titel
			$message = "Hello ".$_POST['fullname']."<P>\r\n\r\n";
			$message .= "\t<BLOCKQUOTE>";

			$message .= "\tThank you for showing your support for the Color Orange. Please confirm that you want to have your name on the list of supporters by clicking <A HREF='$SITE_INFO_PUBLIC_ROOT".$_GET['lang']."/page-2?id=".$row['sid']."&code=".$row['time']."'>this link</A><BR>\r\n";
			$message .= "\t(The mail, and confirmation is done to avoid spam on the support list)";
			$message .= "\t</BLOCKQUOTE>";
			$message .= "Thank you again for your support,\r\n\r\n<BR><BR>Sincerely, TheColorOrange\r\n<BR>";
			$headers = "MIME-Version: 1.0\r\n";     
			$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
			$headers .= "$from\r\n";     
			mail($to, $subject, $message, $headers); //Sender mailen 
			$successmsg .= "<H2>Thank you for supporting this project</H2>";
			$successmsg .= "A mail has been sent to you, with a link to follow to confirm you want to join the list of supporters. It will arrive in a few minutes<P>";
			$successmsg .= "See a list of current supporters: <A HREF='$SITE_INFO_PUBLIC_ROOT".$_GET['lang']."/page-2'>List of supporters</A>";			
		}
		if ($successmsg != "") { 
			echo $successmsg;			
		}
	}
}
if ($successmsg == "") {?>
	<?php	echo "<H2>$errormsg</H2>"; ?>
	<?
	if ($vars['text before form'] != "") {
		echo $vars['text before form'];
		echo "<HR>";
	}
?>
<FIELDSET><LEGEND><B><?php echo $vars['options']; ?>:</B></LEGEND>
<FORM NAME='subscribeform' METHOD='post'>
	<INPUT <?php if (!isset($_POST['submit']) || $_POST['subscribe_check'] == "true") echo "CHECKED='checked'"; ?> name="subscribe_check" value="true" type="checkbox"><?php echo $vars['newsletter checkbox']; ?><br>
<INPUT <?php if (!isset($_POST['submit']) || $_POST['support_check'] == "true") echo "CHECKED='checked'"; ?> NAME='support_check' VALUE='true' type='checkbox'><?php echo $vars['support-list checkbox']; ?><br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<INPUT <?php if (!isset($_POST['submit']) || $_POST['publish_comment'] == "true") echo "CHECKED='checked'"; ?> NAME='publish_comment' VALUE='true' type='checkbox'><?php echo $vars['publish comment checkbox']; ?><br>
</FIELDSET>

<FIELDSET><LEGEND><B><?php echo $vars['info']; ?>:</B></LEGEND>
<TABLE>
<TR><TH ALIGN='left'><?php echo $vars['fullname']; ?>:</TH><TD WIDTH=100%><INPUT TYPE='text' VALUE='<?php echo $_POST["fullname"]; ?>' NAME='fullname' SIZE=40>*</TD></TR>
<TR><TH ALIGN='left'><?php echo $vars['street']; ?>:</TH><TD><INPUT TYPE='text' VALUE='<?php echo $_POST["street"]; ?>' NAME='street' SIZE=40></TD></TR>
<TR><TH ALIGN='left'><?php echo $vars['city']; ?>:</TH><TD><INPUT TYPE='text' VALUE='<?php echo $_POST["city"]; ?>' NAME='city' SIZE=40></TD></TR>
<TR><TH ALIGN='left'><?php echo $vars['postal']; ?>:</TH><TD><INPUT TYPE='text' VALUE='<?php echo $_POST["postal"]; ?>' NAME='postal' SIZE=8></TD></TR>
<TR><TH ALIGN='left'><?php echo $vars['country']; ?>:</TH><TD><INPUT TYPE='text' VALUE='<?php echo $_POST["country"]; ?>' NAME='country' SIZE=40>*</TD></TR>
<TR><TH ALIGN='left'><?php echo $vars['email']; ?>:</TH><TD><INPUT TYPE='text' VALUE='<?php echo $_POST["email"]; ?>' NAME='email' SIZE=40>*</TD></TR>
<TR><TH ALIGN='left'><?php echo $vars['comments']; ?>:</TH><TD><TEXTAREA NAME='comments' ROWS=7 COLS=50><?php echo $_POST["comments"]; ?></TEXTAREA></TD></TR>
<TR><TD COLSPAN=2>
<?php echo $vars['note']; ?></TD></TR>
<TR><TH></TH><TD><INPUT TYPE='submit' VALUE='<?php echo $vars["submit button"]; ?>' NAME='submit'> <INPUT TYPE='reset' VALUE='<?php echo $vars["reset button"]; ?>'></TD></TR>
</TABLE>
</FIELDSET>
</FORM>
<?php
 }
?>
