<style type="text/css">
<?php 
//Get info from database
$query = "SELECT element, property, value FROM layout_properties WHERE layoutID='-1' ORDER BY priority DESC, element ASC";
//echo $query;
$result = mysql_query($query);
while ($row = mysql_fetch_assoc($result)) {
	echo $row['element']." { ".$row['property'].":".$row['value']."; }\n";
}
?>


/* ---------------------- LEFT MENU ----------------------- */

A.leftmenu-links 
{ 
  color:white;
  font-size:11px;
  font-weight:bold;
  text-decoration:none;
  font-family:verdana;
 }

.leftmenu-links A:HOVER 
{ 
  color:#F8DB38;
  }
TD.leftmenu-links 
{ 
  padding:0px 10px 5px 10px;
 }

TD.leftmenu-links IMG 
{  
  padding:0px 3px 0px 0px;
}

TD.dots { 
  background: url(http://www.thecolororange.net/layout/spacer1.gif);
  background-repeat:repeat-x;
  height:1px;
 }

TABLE.leftmenu-spacer 
{ 
  width:100%;
 }

TD.leftmenu-spacer 
{ 
  height:10px;
  padding:0px 7px 3px 7px;
 }



/* ------------------- OTHER STUFF ------------------------------ */
TD.translations 
{ 
  text-align:right;
 }

IMG.linkflags 
{ 
  width:20px;
  height:13px;
  border:0px;
  padding:0px 0px 0px 5px;
 }

IMG.translationflags 
{ 
  width:20px;
  height:13px;
  border:0px;
  padding:0px 0px 0px 5px;
 }

A.listingTypeLink
{ 
  ;
 }

A.listingTypeIndexLink
{ 
  font-weight:bold;
 }

LI.listingTypeHeader
{ 
  font-weight:bold;
 }

TABLE.listingDescriptionFlags 
{ 
  border:1px;
  width:100%;
 }

IMG.listingDescriptionFlagsImg
{ 
  width:135px;
  height:100px;
 }

/* ------------------ SUPPORT LIST ------------------------ */
TH.supportlist
{
  padding:10px 0px 0px 0px;
 }


FONT.supportlist-name
{ 
  font-weight:bold;
  color:black;
  font-size:13px;
 }

FONT.supportlist-location
{ 
  font-weight:normal;
  color:black;
 }

TD.supportlist-date
{ 
  text-align:right;
  font-weight:bold;
  color:black;
 }

TD.supportlist-comment 
{ 
  font-weight:normal;
  color:#FF8900;                         
 }

/* ---------------- COUNTER ------------------------------- */
DIV.counter 
{ 
  text-align:center;
 }

TD.counter 
{ 
  font-weight:bold;
  font-family:monospace;
  font-size:18px;
  color:white;
  background-color:#000000;
  margin:0px 2px 0px 2px;
  }

TABLE.counter
{ 
  background-color:#000000;
  text-align:center;
  margin-left:auto; 
  margin-right:auto;
 }

FONT.counter
{ 
  text-align:center;
 }

</style>
