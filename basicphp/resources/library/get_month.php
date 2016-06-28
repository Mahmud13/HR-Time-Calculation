<?php
require_once("../config.php");
include 'db.inc.php';
$staf = $_GET['staffpin'];
$yr = $_GET['year'];
if($staf != "" and $yr != ""){
	$sql = "SELECT `date` FROM RawTimeTable WHERE `pin` = $staf and `date` LIKE '%$yr%'";
	$result = mysqli_query($link, $sql);
	if(!$result){
		$error = 'Error fetching list of month.'. mysqli_error($link);
		include 'error.html.php';
		require_once(TEMPLATES_PATH . "/footer.php");
		exit();
	}
}

echo "<label>Month: </label>
<select name='month'>
<option value=''>Select Month</option>";
$etmp = 'selected = "selected"';
while ($row = mysqli_fetch_array($result))
{
	$tmp  = date("F", strtotime($row['date']));
	$month [] = $tmp;
	
}
$months = array_unique($month);
foreach($months as $month){
	echo "<option value=$month>$month</option>";	
}
echo "</select><br>";
?>
