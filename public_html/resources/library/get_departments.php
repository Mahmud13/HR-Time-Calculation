<?php
//require_once("resources/config.php");
include 'db.inc.php';
$sql = 'SELECT DISTINCT `id`, `name` FROM departments ORDER BY `name`';
$result = mysqli_query($link, $sql);

if(!$result){
	$error = 'Error fetching list of departments.'. mysqli_error($link);
	include 'error.html.php';
	require_once(TEMPLATES_PATH . "/footer.php");
	exit();
}
while ($row = mysqli_fetch_array($result))
{
	$departments [] = array('id'=>$row['id'], 'name'=>$row['name']);
}

?>
