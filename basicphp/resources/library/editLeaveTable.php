<?php
include "../config.php";
include 'db.inc.php';
if(!isset($_POST['medicalleave']) or !isset($_POST['month']) or !isset($_POST['pin'])){
	echo 'error';
	exit();	
}
$medicalleave = $_POST['medicalleave'];
$casualleave = $_POST['casualleave'];
$len = count($medicalleave)-1;
$month = explode(' ', $_POST['month'] );
$year = $month[1];
$month = $month[0];
$monthid = date("m", strtotime("2015-$month-01"));
$pin = $_POST['pin'];
$startdate = "$year-$monthid-01";
$enddate = "$year-$monthid-$len";
$sql1 = 'UPDATE RawTimeTable SET `medicalleave` = CASE date ';
$sql2 = 'UPDATE RawTimeTable SET `casualleave` = CASE date ';
for($i=1; $i<=$len; $i++){
	$ml = $medicalleave[$i];
	$cl = $casualleave[$i];
	$dt = $i<10 ? "$year-$monthid-0$i" : "$year-$monthid-$i";
	$sql1.= 'WHEN "'. $dt. '" THEN "'. $ml. '" ';
	$sql2.= 'WHEN "'. $dt. '" THEN "'. $cl. '" ';
}
$sql1.= 'END WHERE `pin`="'.$pin.'" AND `date` BETWEEN "'. $startdate . '" AND "' . $enddate . '"; '; 
$sql2.= 'END WHERE `pin`="'.$pin.'" AND `date` BETWEEN "'. $startdate . '" AND "' . $enddate . '";'; 
$result1 = mysqli_query($link, $sql1);
$result2 = mysqli_query($link, $sql2);
if(!$result1 or !$result2){
		echo  mysqli_error($link);
}
?>
