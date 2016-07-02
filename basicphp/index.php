<?php    
require_once('resources/config.php');
require('resources/library/magicquotes.inc.php');
$pagetitle = "HR Database";
require_once(LIBRARY_PATH . "/helpers.inc.php");
require_once(TEMPLATES_PATH . "/header.php");
require_once(TEMPLATES_PATH . "/nav.php");
if (!isset($departments)) 
{  
		require(LIBRARY_PATH . '/get_departments.php');  
}
include(TEMPLATES_PATH . "/searchtool.php");
if(isset($_POST['action']) and $_POST['action']=="viewTime"
				and isset($_POST['departmentid']) and $_POST['departmentid'] !=""
				and isset($_POST['staffpin']) and $_POST['staffpin'] !=""
				and isset($_POST['year']) and $_POST['year'] !=""
				and isset($_POST['month']) and $_POST['month'] !=""){
		include(LIBRARY_PATH . "/createtable.php");
		include(TEMPLATES_PATH . "/viewtable.php");
}else if(isset($_POST['action']) and $_POST['action']=="viewLeave"
				and isset($_POST['departmentid']) and $_POST['departmentid'] !=""
				and isset($_POST['staffpin']) and $_POST['staffpin'] !=""
				and isset($_POST['year']) and $_POST['year'] !=""
				and isset($_POST['month']) and $_POST['month'] !=""){

		include(LIBRARY_PATH . "/createLeavetable.php");
		include(TEMPLATES_PATH . "/viewLeavetable.php");
}
require_once(TEMPLATES_PATH . "/footer.php");
?>
