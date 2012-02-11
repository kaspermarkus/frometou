<?php
require_once("authorize.php");
require_once("../functions/siteInfo.php");

$filename = "editCss.php";
$id = "pid";

/* ------------- if form is submitted -------------- */
if (isset($_GET['modify'])) {
	$query = "UPDATE layout_properties SET value='".$_GET['value']."' WHERE pid='".$_GET['pid']."'";  
	mysql_query($query);
	header("location:$filename");
} else if (isset($_GET['add'])) {
	$query = "INSERT INTO layout_properties (pid,layoutID,element,property,value,description,priority) VALUES (NULL,'".$_GET['layoutID']."', '".$_GET['element']."', '".$_GET['property']."', '".$_GET['value']."', '', '".$_GET['priority']."')";
	mysql_query($query);
	header("location:$filename");
 } else if (isset($_GET['delete'])) {
	$query = "DELETE FROM layout_properties WHERE pid='".$_GET['pid']."'";
	mysql_query($query);
	header("location:".$filename);
}

if (!isset($_GET['layoutID'])) {
	$layoutID=-1;
}

$sql = "SELECT pid,element,property,value,description,priority FROM layout_properties WHERE layoutID=$layoutID ORDER BY priority DESC, element ASC";
$result = mysql_query($sql);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta content="text/html; charset=ISO-8859-1" http-equiv="content-type"/>
<LINK REL="stylesheet" type="text/css" href="css/general.css">
<title>Edit styles</title>
</head>
<body>
<TABLE BORDER=0 WIDTH='100%'><TR><TD><H1>Edit Styles</H1></TD>
</TABLE>
	<HR>
<BR>
	<TABLE>
	<TR>
	<TH align=left>Priority</TH>
	<TH align=left>Element</TH>
	<TH align=left>Property</TH>
	<TH align=left>Value</TH>
	<TH></TH>
	</TR>
	<TR>
	<TD><FORM target="_self" method="get" action="<?php echo $filename; ?>" name="f2">
	<input type='hidden' name="layoutID" value="<?php echo $layoutID; ?>">
	<input size="5" name="priority" value="500"></TD>
	<TD><input size="20" name="element" value=""></TD>
	<TD><input size="20" name="property" value=""></TD>
	<TD><input size="20" name="value" value=""></TD>
	<TD><INPUT TYPE="submit" value="add" name="add"></FORM></TD>
	<TD></TD>
	</TR>
	<?php
	$i=0;
	while ($r = mysql_fetch_assoc($result)) {
		if ($i%10 == 0) {
			?>
			<TR>
			<TH align=left>Priority</TH>
			<TH align=left>Element</TH>
			<TH align=left>Property</TH>
			<TH align=left>Value</TH>
			<TH></TH>
			</TR>
		<?php
		}
		?>
	    	<TR>
	    	<TD><FORM target="_self" method="get" action="<?php echo $filename; ?>" name="f2">
	    	    <input type='hidden' name="<?php echo $id; ?>" value="<?php echo $r['pid']; ?>">
	    	    <input type='hidden' name="layoutID" value="<?php echo $layoutID; ?>">
	            <?php echo $r['priority']; ?></TD>
	        <TD><?php echo $r['element']; ?></TD>
	        <TD><?php echo $r['property']; ?></TD>
	   	<TD><input size="20" name="value" value="<?php echo $r['value']; ?>"></TD>
		<TD><INPUT TYPE="submit" value="save" name="modify"></TD>
		<TD><INPUT TYPE="submit" value="delete" name="delete" onClick="return confirmSubmit()"></FORM></TD>
		</TR>
	<?php
		$i++;
	}
	?>
	</TABLE>
	
	</body>
	</html>
