<?php
$query = "SELECT * FROM special_text as st, special_text_v as stv, lang WHERE st.stid = stv.stid AND st.category = 'followup' AND lang.langid = stv.langid AND lang.shorthand = '".(($_GET['tmplang']=='') ? $_GET['lang'] : $_GET['tmplang'])."'";
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
	if ($_POST['Project'] == "") {
		echo "Please enter a name of your project<BR><BR>";
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
	  $query = "INSERT INTO followups ( sid, projectname, country, link, description, active ) VALUES ( ";
	  $query .= " '', '".$_POST['projectname']."', '".$_POST['country']."', ";
	  $query .= "'http://".$_POST['link']."'";
	  $query .= ", '".$_POST['description']."'";
	  $query .= ", '0' )";
	  mysql_query($query);

	  $query = "SELECT sid, DATE_FORMAT(time, '%s%H%c%y%i%j') as time FROM followups WHERE projectname='".$_POST['projectname']."' AND link='http://".$_POST['link']."' AND country='".$_POST['country']."' ORDER BY sid DESC";
	  echo $query;
	  $result = mysql_query($query);
	  $row = mysql_fetch_assoc($result);
	  $to = $_POST['projectname']." <".$_POST['email'].">";
	  $from = "From: The Color Orange <info@thecolororange.net>"; 
	  $subject = "TheColorOrange: Confirmation of follow up project"; //Mailens titel
	  $message = "Hello ".$_POST['projectname']."<P>\r\n\r\n";
	  $message .= "\t<BLOCKQUOTE>";
	  
	  $message .= "\tThank you for showing your support for the Color Orange. Please confirm that you want your follow up project posted on the ColorOrange website by clicking <A HREF='$SITE_INFO_PUBLIC_ROOT".$_GET['lang']."/page-8?id=".$row['sid']."&code=".$row['time']."'>this link</A><BR>\r\n";
	  $message .= "\t(The mail, and confirmation is done to avoid spam on the follow up list)";
	  $message .= "\t</BLOCKQUOTE>";
	  $message .= "Thank you again for your support,\r\n\r\n<BR><BR>Sincerely, TheColorOrange\r\n<BR>";
	  $headers = "MIME-Version: 1.0\r\n";     
	  $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
	  $headers .= "$from\r\n";     
	  mail($to, $subject, $message, $headers); //Sender mailen 
	  $successmsg .= "<H2>Thank you for showing your support</H2>";
	  $successmsg .= "A mail has been sent to you, with a link to follow to confirm you want to post your project to the list. It will arrive in a few minutes<P>";
	  $successmsg .= "See a list of current projects: <A HREF='$SITE_INFO_PUBLIC_ROOT".$_GET['lang']."/page-8'>Follow up projects</A>";			
	}
	if ($successmsg != "") { 
	  echo $successmsg;			
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
<FORM NAME='followupform' METHOD='post'>

<FIELDSET><LEGEND><B><?php echo $vars['info']; ?>:</B></LEGEND>
<TABLE>
<TR><TH ALIGN='left'><?php echo $vars['projectname']; ?>:</TH><TD WIDTH=100%><INPUT TYPE='text' VALUE='<?php echo $_POST["projectname"]; ?>' NAME='projectname' SIZE=40>*</TD></TR>
<TR><TH ALIGN='left'><?php echo $vars['country']; ?>:</TH><TD><INPUT TYPE='text' VALUE='<?php echo $_POST["country"]; ?>' NAME='country' SIZE=40>*</TD></TR>
							 <TR><TH ALIGN='left'><?php echo $vars['link']; ?>:</TH><TD>http://<INPUT TYPE='text' VALUE='<?php echo $_POST["link"]; ?>' NAME='link' SIZE=30></TD></TR>
<TR><TH ALIGN='left'><?php echo $vars['email']; ?>:</TH><TD><INPUT TYPE='text' VALUE='<?php echo $_POST["email"]; ?>' NAME='email' SIZE=40>*</TD></TR>
<TR><TH ALIGN='left'><?php echo $vars['description']; ?>:</TH><TD><TEXTAREA NAME='description' ROWS=7 COLS=50><?php echo $_POST["description"]; ?></TEXTAREA></TD></TR>
<TR><TD COLSPAN=2>
<?php echo $vars['note']; ?></TD></TR>
<TR><TH></TH><TD><INPUT TYPE='submit' VALUE='<?php echo $vars["submit button"]; ?>' NAME='submit'> <INPUT TYPE='reset' VALUE='<?php echo $vars["reset button"]; ?>'></TD></TR>
</TABLE>
</FIELDSET>
</FORM>
<?php
 }
?>
