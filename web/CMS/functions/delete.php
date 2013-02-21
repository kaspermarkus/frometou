delete files n´ stuff!!!<br>


<?php

	function deleteDocModule($did,$lang) {
	    $query = "DELETE FROM doc_module_v WHERE did='$did' AND langid='$lang'";
		mysql_query($query);
		echo $query."<br>";
	}

	function deleteDocGeneral($did,$lang) {
		$query = "DELETE FROM doc_general_v WHERE did='$did' AND langid='$lang'"; 
		mysql_query($query);
		echo $query."<br>";
	}


//WARNINIG - NOT LANGUAGE SPECIFIC
	function deleteHierarchy($did) {
		mysql_query("DELETE FROM hierarchy WHERE did=$did");
		mysql_query("DELETE FROM hierarchy WHERE parent=$did");
	}


//WARNINIG - NOT LANGUAGE SPECIFIC
	function DeleteDocComplete($did) {
		mysql_query("DELETE FROM doc WHERE did=$did");
		mysql_query("DELETE FROM doc_general_v WHERE did=$did");
		mysql_query("DELETE FROM doc_module_v WHERE did=$did");
		//TODO:  Load all general modules to delete doc entry (if exist)
		mysql_query("DELETE FROM hierarchy WHERE did=$did");
		mysql_query("DELETE FROM hierarchy WHERE parent=$did");
	}


	function DeleteDocForm($did) {

		if(isset($_POST['DeleteDoc'])) {		
			deleteHierarchy($did);
			DeleteDocComplete($did);
		} else {
			echo "<FORM method='POST' NAME='DeleteDoc' ACTION='http://localhost/frometou/web/cms/editDocs.php?did=$did'>";
			echo "<INPUT TYPE='submit' value='delete' name='DeleteDoc'>";
			echo "<form>";
		}
	}


	function DeleteDocLangForm($did,$lang) {
		
		if(isset($_POST['DeleteLangDoc'])) {
			deleteDocModule($did,$lang);
			deleteDocGeneral($did,$lang);
		} else {	
			echo "<FORM method='POST' NAME='DeleteLangDoc' ACTION='http://localhost/frometou/web/cms/editDocs.php?did=$did'>";
			echo "<INPUT TYPE='submit' value='delete' name='DeleteLangDoc'>";
			echo "<form>";
		}
	}

//	DeleteDocLangForm('98','dk');
//	DeleteDocForm('98','dk');
?>



<br>