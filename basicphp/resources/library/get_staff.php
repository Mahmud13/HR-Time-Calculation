<?php
require_once("../config.php");
include 'db.inc.php';
$dept = $_GET['department_id'];

if($dept != "" and $dept!="-1"){
	$sql = 'SELECT `name`,`pin` FROM RawNameTable WHERE `department_id` = "'.$dept.'" ORDER BY `name`';
}else{
	$sql = "SELECT `name`,`pin` FROM RawNameTable ORDER BY `name`";
}
//echo "<script>alert($dept)<\script>";
$result = mysqli_query($link, $sql);

if(!$result){
	$error = 'Error fetching list of staff.'. mysqli_error($link);
	include 'error.html.php';
	require_once(TEMPLATES_PATH . "/footer.php");
	exit();
}

echo "<label>Staff name:</label>
<select name='staffpin' id='staffpin' onChange='getYear(this.value)'>
<option value=''>Select Staff</option>";

while ($row = mysqli_fetch_array($result))
{
	$staff [] = array('pin'=>$row['pin'], 'name'=>$row['name']);
	$staffname = $row['name'];
	$pin = $row['pin'];
	$etmp = 'selected = "selected"';

	echo "<option value=$pin>$staffname</option>";
}

echo "</select><br><br>";
?>
