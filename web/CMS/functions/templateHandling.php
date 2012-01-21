<?php
function safe_copy_template_entries($fromTemplate) {
	$to = -1;
	$query="SELECT * FROM layout_properties WHERE layoutID='$fromTemplate'";
	$result=mysql_query($query);
	while ($row = mysql_fetch_assoc($result)) {
		$query = "INSERT INTO `web26db1`.`layout_properties` ( pid, layoutID, element, property, value, description,priority) VALUES (";
		$query .= "NULL , '$to', '".$row['element']."' , '".$row['property']."', '".$row['value']."' , '".$row['description']."' , '".$row['priority']."')";
		mysql_query($query);
	}
}

function delete_template_entries() {
	$del = -1;
	$query="DELETE FROM layout_properties WHERE layoutID='$del'";
	$result=mysql_query($query);
}
?>
