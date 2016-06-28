<?php
//require_once("../config.php");
include 'db.inc.php';
$yr = $_POST['year'];
$staf = $_POST['staffpin'];
if ($yr!="" and $staf!=""){
	$sql = "SELECT `date` FROM RawTimeTable WHERE `pin` = $staf and `date` LIKE '%$yr%'";
	$result = mysqli_query($link, $sql);
}
if(!$result){
	$error = 'Error fetching list of Month.'. mysqli_error($link);
	include 'error.html.php';
	require_once(TEMPLATES_PATH . "/footer.php");
	exit();
}

while ($row = mysqli_fetch_array($result))
{
	$tmp  = date("F", strtotime($row['date']));
	$month [] = $tmp;
	
}
$months = array_unique($month);

?>
