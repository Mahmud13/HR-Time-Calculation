<?php
require_once("../config.php");
include 'db.inc.php';
$staf = $_GET['spin'];
$sql = "SELECT `date` FROM RawTimeTable WHERE `pin` = $staf ORDER BY `date`";
$result = mysqli_query($link, $sql);
if(!$result){
	$error = 'Error fetching list of year.'. mysqli_error($link);
	include 'error.html.php';
	require_once(TEMPLATES_PATH . "/footer.php");
	exit();
}
echo "<label>Year:</label>
<select name='year' onChange='getMonth(this.value)'>
<option value=''>Select Year</option>";
while ($row = mysqli_fetch_array($result))
{
	$tmp  = date("Y", strtotime($row['date']));
	$year [] = $tmp;
}
$years = array_unique($year);
$etmp = 'selected = "selected"';
foreach($years as $year){

	echo "<option value=$year>$year </option>";	
}

echo "</select><br><br>";
?>
