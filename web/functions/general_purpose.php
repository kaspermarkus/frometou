<?php
function getTypes() {
	$query = "SELECT lang.id as lang, dtype.tid, dtype_v.tname FROM dtype, dtype_v, lang WHERE dtype_v.tid = dtype.tid AND lang.id = dtype_v.langid";
	//echo $query;
	$result = mysql_query($query);
	while ($row = mysql_fetch_assoc($result)) {
		if ($row['lang'] == $_SESSION['lang']) {
			$types[$row['tid']] = $row['tname'];
			continue;
		} else if (!isset($types[$row['tid']])) {
			$types[$row['tid']] = $row['tname'];
		}
	}
	return $types;
}
?>
