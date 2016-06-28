<?php
require_once("../config.php");
include "db.inc.php";
$pin = $_GET['staffpin'];
$sql = "SELECT `department_id` FROM RawNameTable WHERE `pin`=$pin";
$result = mysqli_query($link, $sql);

if(!$result){
	$error = 'Error fetching list of departments.'. mysqli_error($link);
	include 'error.html.php';
	exit();
}
if ($row = mysqli_fetch_array($result))
{
	$departmentid = $row['department_id'];
	echo $departmentid;
}else{
	echo "-1";
}

?>
