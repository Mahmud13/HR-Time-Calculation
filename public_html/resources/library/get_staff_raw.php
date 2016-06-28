<?php
//require_once("../config.php");
include 'db.inc.php';
if(isset($_POST['departmentid'])){
	$dept = $_POST['departmentid'];
}else{
	$dept = "";
}

if($dept!=""){
	$sql = "SELECT `name`,`pin` FROM RawNameTable WHERE `department_id` = $dept ORDER BY `name`" ;
}else{
	$sql = "SELECT `name`,`pin` FROM RawNameTable ORDER BY `name`";
}
$result = mysqli_query($link, $sql);
if(!$result){
	$error = 'Error fetching list of staff.'. mysqli_error($link);
	include 'error.html.php';
	require_once(TEMPLATES_PATH . "/footer.php");
	exit();
}
while ($row = mysqli_fetch_array($result))
{
	$staff [] = array('pin'=>$row['pin'], 'name'=>$row['name']);
}
?>
