<?php

  /* check if we are activating a followu */
if (isset($_GET['code']) && isset($_GET['id'])) {
	$_GET['code'] = str_replace("'", "8", $_GET['code']);
	$_GET['code'] = str_replace('"', "8", $_GET['code']);
	$_GET['id'] = str_replace('"', "8", $_GET['id']);
	$_GET['id'] = str_replace('"', "8", $_GET['id']);
	$query = "SELECT * FROM followups WHERE sid='".$_GET['id']."' AND DATE_FORMAT(time, '%s%H%c%y%i%j') = '".$_GET['code']."'";
	//echo $query;
	if (mysql_num_rows(mysql_query($query)) > 0) {
		$query = "UPDATE followups SET active='1' WHERE sid='".$_GET['id']."' AND DATE_FORMAT(time, '%s%H%c%y%i%j') = '".$_GET['code']."'";
		mysql_query($query);
		echo "You have successfully added your follow up project of The Color Orange! Thank You.<BR><BR>";
		echo "<BR>";
		echo "To see the list of all the follow up projects follow <A HREF='$SITE_INFO_PUBLIC_ROOT".$_GET['lang']."/page-8'>this link</A>";
	} else {
		echo "An error occured.. Could not confirm the code for your follow up of TheColorOrange.. Please goto <A HREF='$SITE_INFO_PUBLIC_ROOT".$_GET['lang']."/page-9'>this page</A> and try again...<BR><BR>";
		echo "Sorry for the inconvenience!<BR>";
		echo "<BR";
		echo "Sincerely, The Color Orange";
	}
 } else {
	/* Show the list of supporters */
	$query = "SELECT * FROM special_text as st, special_text_v as stv, lang WHERE st.stid = stv.stid AND st.category = 'followup' AND stv.langid = lang.langid AND lang.shorthand = '".(($_GET['tmplang'] == '') ? $_GET['lang'] : $_GET['tmplang'])."' AND field='prelisttext'";
	$supportlisttext = mysql_query($query);
	$supportlisttext1 = mysql_fetch_assoc($supportlisttext);
	echo "<BR>".$supportlisttext1['value'];

	echo "<BR><HR>";
	$query = "SELECT projectname, link, country, description, DATE_FORMAT(time, '%d. %b %y') as ftime FROM followups WHERE active = '1' ORDER BY time DESC";

	$result = mysql_query($query);
	$first = null;
	while ($row = mysql_fetch_assoc($result)) {
		if ($first != null) {
			echo "<HR>";
		}
		echo "<TABLE WIDTH=100%>";
		echo "<TH CLASS='supportlist'><FONT CLASS='supportlist-name'><A HREF='".$row['link']."'>".$row['projectname']."</A></FONT> <FONT CLASS='supportlist-location'>(";
		echo $row['country']."</FONT>)</TH><TR>";
		echo "<TR><TD CLASS='supportlist-comment' COLSPAN=2>".(substr($row['description'], 0, min(1000, strlen($row['description']))))."</TD></TR>";
		echo "</TABLE>\n";
	}
 }

?>
