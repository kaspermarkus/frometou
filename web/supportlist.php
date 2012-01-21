<?php

  /* check if we are activating a subscription */
if (isset($_GET['code']) && isset($_GET['id'])) {
	$_GET['code'] = str_replace("'", "8", $_GET['code']);
	$_GET['code'] = str_replace('"', "8", $_GET['code']);
	$_GET['id'] = str_replace('"', "8", $_GET['id']);
	$_GET['id'] = str_replace('"', "8", $_GET['id']);
	$query = "SELECT * FROM supporters WHERE sid='".$_GET['id']."' AND DATE_FORMAT(time, '%s%H%c%y%i%j') = '".$_GET['code']."'";
	//echo $query;
	if (mysql_num_rows(mysql_query($query)) > 0) {
		$query = "UPDATE supporters SET active='1' WHERE sid='".$_GET['id']."' AND DATE_FORMAT(time, '%s%H%c%y%i%j') = '".$_GET['code']."'";
		mysql_query($query);
		echo "You have successfully confirmed you support for the ideas of The Color Orange! Thank You.<BR><BR>";
		echo "<BR>";
		echo "To see the list of supporters <A HREF='$publicRoot".$_GET['lang']."/page-2'>this link</A>";
	} else {
		echo "An error occured.. Could not confirm the code for supporting the ideas of TheColorOrange.. Please goto <A HREF='$publicRoot".$_GET['lang']."/page-1'>this page</A> and try again...<BR><BR>";
		echo "Sorry for the inconvenience!<BR>";
		echo "<BR";
		echo "Sincerely, The Color Orange";
	}
 } else {
	/* Show the list of supporters */
	$query = "SELECT * FROM special_text as st, special_text_v as stv, lang WHERE st.stid = stv.stid AND st.category = 'support-list' AND stv.langid = lang.langid AND lang.shorthand = '".(($_GET['tmplang'] == '') ? $_GET['lang'] : $_GET['tmplang'])."'";
	$supportlisttext = mysql_query($query);
	$supportlisttext1 = mysql_fetch_assoc($supportlisttext);
	echo "<BR>".$supportlisttext1['value'];
	echo "<BR><BR><HR>";
	$query = "SELECT fullname, country, city, comments, DATE_FORMAT(time, '%d. %b %y') as ftime FROM supporters WHERE active = '1' ORDER BY time DESC";
	$result = mysql_query($query);
	$first = null;
	while ($row = mysql_fetch_assoc($result)) {
		if ($first != null) {
			echo "<HR>";
		}
		echo "<TABLE WIDTH=100%>";
		echo "<TH CLASS='supportlist'><FONT CLASS='supportlist-name'>".$row['fullname']."</FONT>, <FONT CLASS='supportlist-location'>(";
		if ($row['city'] != "") { echo $row['city'].", "; }
		echo $row['country']."</FONT>)</TH><TD CLASS='supportlist-date'>".$row['ftime']."</TD></TR>";
		echo "<TR><TD CLASS='supportlist-comment' COLSPAN=2>".(substr($row['comments'], 0, min(500, strlen($row['comments']))))."</TD></TR>";
		echo "</TABLE>\n";
	}
 }

?>
