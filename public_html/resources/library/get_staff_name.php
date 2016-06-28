<?php
//require_once("../config.php");
include 'db.inc.php';
$staffpin = $_GET['staffpin'];

if($staffpin != ""){
	$sql = "SELECT `name`,`pin`, `department_id` FROM RawNameTable WHERE `pin` = $staffpin";
	$result = mysqli_query($link, $sql);
	if(!$result){
		$error = 'Error fetching list of staff.'. mysqli_error($link);
		include 'error.html.php';
		require_once(TEMPLATES_PATH . "/footer.php");
		exit();
	}
	if(mysqli_num_rows($result)){
		$row = mysqli_fetch_array($result);
		$staffname = $row['name'];
		$pin = $row['pin'];
		echo "<label>Staff name:</label><select name='staffpin' onChange='getYear(this.value)'><option value=$pin>$staffname</option></select><br><br>";
		exit();
	}
}
$sql = "SELECT `name`,`pin`, `department_id` FROM RawNameTable";
$result = mysqli_query($link, $sql);
if(!$result){
		$error = 'Error fetching list of staff.'. mysqli_error($link);
		include 'error.html.php';
		require_once(TEMPLATES_PATH . "/footer.php");
		exit();
}
$row = mysqli_fetch_array($result);

//echo "<script>alert($dept)<\script>";




echo "<label>Staff name:</label>
<select name='staffpin' onChange='getYear(this.value)'>
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
