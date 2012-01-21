<?php

/* fix mails / signup etc */
if (isset($_GET['email'])) {
	foreach ($_GET as $ind=>$val) {
		$val = strip_tags($val);
		$val = str_replace("'", " ", $val);
		$val = str_replace('"', " ", $val);
		$val = substr($val, 0, min(strlen($val), 150));
		$val = trim($val);
		$_POST[$ind] = $val;
	}

	if (isset($_GET['email']) && isset($_GET['id']) && isset($_GET['type'])) {
		if ($_GET['type'] == "c") {
			$table = "confirmers";
			$usrtext = "You have successfully been subscribed to the mailing list. If you want to unsubscribe, use the link found in the emails you recieve";
			$mailtext = "MAILLIST: confirmed email ";
		} else {
			$table = "unsubscribers";
			$usrtext = "You have successfully been removed from mailinglist. If you at anytime want to subscribe again, please go to: <A HREF='http://www.thecolororange.net/uk/page-1'>this page</a>";
			$mailtext = "MAILLIST: unsubscribe email ";
		}
		$sql = "INSERT INTO $table ( `ID` , `email` , `DBID` ) VALUES ( NULL , '".$_GET['email']."', '".$_GET['id']."')";
		mysql_query($sql);

		/** fix mail for ourself */
		$to = "info@thecolororange.net"; 
		$subject = $mailtext.$_GET['email']." - id: ".$_GET['id']; //Emnefeltet
		$message = $subject;
		$header  = "MIME-Version: 1.0" . "\r\n";
		$header .= "from:info@thecolororange.net";
		mail($to, $subject, $message, $header); //Send!! 

	} else {
		$usrtext = "An error have occurred. Please contact <A HREF='mailto:contact@thecolororange.net'>contact@thecolororange.net</A> to unsubscribe or confirm you subscription";
	}
 } else {
	$usrtext = "An error have occurred. Please contact <A HREF='mailto:contact@thecolororange.net'>contact@thecolororange.net</A> to unsubscribe or confirm you subscription";
}
echo "<H2>TheColorOrange network</H2>";
echo $usrtext;
echo "<BR><HR>";
?>
