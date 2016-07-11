<?php 
require_once('classes/staff.class.php');
require_once('classes/DB.class.php');
$db = new DB();
//echo $db->connect();
$a_staff = new Staff();
echo $a_staff;

$a_staff = new Staff("mahmud", "123");
echo "<br>". $a_staff;

$a_staff = new Staff("mahmud");
echo "<br>" . $a_staff;
?>
