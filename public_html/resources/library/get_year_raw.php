<?php
//require_once("../config.php");
include 'db.inc.php';
$yr = $_POST['year'];
$sql = "SELECT `date` FROM RawTimeTable WHERE `date` LIKE '%$yr%' ORDER BY `date`";
$result = mysqli_query($link, $sql);
if(!$result){
	$error = 'Error fetching list of year.'. mysqli_error($link);
	include 'error.html.php';
	require_once(TEMPLATES_PATH . "/footer.php");
	exit();
}

while ($row = mysqli_fetch_array($result))
{
	$tmp  = date("Y", strtotime($row['date']));
	$years [] = $tmp;
}
$years = array_unique($years);

?>
