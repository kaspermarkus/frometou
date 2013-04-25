<?php

	function deleteDocModule($did,$lang) {
	    $query = "DELETE FROM doc_module_v WHERE did='".$did."' AND langid='".$lang."'";
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
			deleteHierarchy($did);
			DeleteDocComplete($did);
	}


	function DeleteDocLangForm($did,$lang) {		
			deleteDocModule($did,$lang);
			deleteDocGeneral($did,$lang);
	}

//	DeleteDocLangForm('98','dk');
//	DeleteDocForm('98');
?>



<br>