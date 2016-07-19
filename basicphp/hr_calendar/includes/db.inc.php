<?php
$db = $config['db'];
$link = mysqli_connect($db['host'], $db['username'], $db['password']);
if (!$link)
{
	$error = 'Unable to connect to the database server.';
	include 'error.html.php';
	exit();
}

if (!mysqli_set_charset($link, 'utf8'))
{
	$output = 'Unable to set database connection encoding.';
	include 'output.html.php';
	exit();
}

if (!mysqli_select_db($link, $db['dbname']))
{
	$error = 'Unable to locate the ' . $db['dbname'] . ' hr database.';
	include 'error.html.php';
	exit();
}
//$sql = 'SELECT * from RawNameTable';
//$result = mysqli_query($link, $sql);
//while ($row = mysqli_fetch_array($result))
//{
	//$x = rand(1,6);
	
	//$y = $row['pin'];
	//$sql = "UPDATE RawNameTable SET `department_id`=$x WHERE `pin`=$y";
	//mysqli_query($link, $sql);
//}
?>
