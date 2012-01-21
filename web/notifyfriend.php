<?php
$query = "SELECT * FROM special_text as st, special_text_v as stv, lang WHERE st.stid = stv.stid AND st.category = 'notify-friend' AND stv.langid = lang.langid AND lang.shorthand = '".(isset($_GET['tmplang']) ? $_GET['tmplang'] : $_GET['lang'])."'";
$result = mysql_query($query);
while ($row = mysql_fetch_assoc($result)) {
	$notifyfriendtext[$row['field']] = $row['value'];
 }

if (isset($_POST['submit'])) {
	/* get recipients' mails: */
	$val = $_POST['recip_emails'];
	$val = strip_tags($val);
	$val = str_replace("'", "`", $val);
	$val = str_replace('"', "`", $val);
	$val = substr($val, 0, min(strlen($val), 500));
	$mail = strtok($val, ",");
	$i = 0;
	while ($mail !== false && $i < 5) {
		$mails[$i++] = trim($mail);
		if ($mails[$i-1] == "") {
			unset($mails[$i]);
			$i--;
		}
		$mail = strtok(",");
	}
	foreach ($mails as $mail) {
		 $from = "From: ".$_POST['name']." <".$_POST['email'].">";
		 $subject = $notifyfriendtext['email subject']." from ".$_POST['name'];
		 $message = $_POST['message'];
		 $message .= "\r\n";
		 $message .= $notifyfriendtext['email extra text'];
		 $headers = "MIME-Version: 1.0\r\n";     
		 $headers .= "Content-type: text/plain; charset=iso-8859-1\r\nContent-Transfer-Encoding: 8bit\r\nX-Priority: 1\r\nX-MSMail-Priority: High\r\n";
		 $headers .= "$from\r\n";
		 $to = $mail;
		 mail($to, $subject, $message, $headers); //Sender mailen 
	}
	echo $notifyfriendtext['email success'];
 } else {
	if ($notifyfriendtext['text before form'] != "") {
		echo $notifyfriendtext['text before form'];
		echo "<HR>";
	}
?>
<FORM METHOD='post'>
<TABLE CELLSPACING="0" CELLPADDING="1" BORDER="0">
  <TR>
		<TH ALIGN='left'><?php echo $notifyfriendtext['name']; ?>:</TH><TD><INPUT TYPE="text" SIZE="30" NAME="name"></TD>
	   </TR>

	   <TR>
		 <TH ALIGN='left'><?php echo $notifyfriendtext['mail']; ?>:</TH>
 <TD><INPUT TYPE="text" SIZE="30" NAME="email"></TD>
</TR>
<TR>
  <TH ALIGN='left'><?php echo $notifyfriendtext['mailto']; ?>:</TH>
  <TD><INPUT TYPE="text" SIZE="53" NAME="recip_emails"></TD>
  
</TR>
<TR>
  <TH ALIGN='left'><?php echo $notifyfriendtext['message']; ?>:</TH>
  <TD>
	<TEXTAREA NAME="message" COLS="45" ROWS="7"><?php echo $notifyfriendtext['default email text']; ?>
	</TEXTAREA>
  </TD>
</TR>
<TR>
  <TD>&nbsp;</TD>
  <TD><INPUT TYPE="submit" NAME='submit' VALUE='<?php echo $notifyfriendtext["submit"]; ?>'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<INPUT TYPE="reset" VALUE='<?php echo $notifyfriendtext["clear"]; ?>'></TD></TD>
  </TR>
</TABLE>
</FORM>
<?php
}
?>
