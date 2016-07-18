<?php
include "../config.php";
include 'db.inc.php';
if(!isset($_POST['medicalleave']) or !isset($_POST['month']) or !isset($_POST['pin'])){
	echo 'error';
	exit();	
}
$flags = $_POST['flag'];
$status = $_POST['status'];
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
$balance = $_POST['balance'];
$sql0 = 'UPDATE RawTimeTable SET `status` = CASE date ';
$sql1 = 'UPDATE RawTimeTable SET `medicalleave` = CASE date ';
$sql2 = 'UPDATE RawTimeTable SET `casualleave` = CASE date ';
$sql3 = 'UPDATE RawTimeTable SET `flag` = CASE date ';
for($i=1; $i<=$len; $i++){
	$st = $status[$i];
	$ml = $medicalleave[$i];
	$cl = $casualleave[$i];
	$fl = $flags[$i]=='W' ? 'workday' : 'holiday';
	$dt = $i<10 ? "$year-$monthid-0$i" : "$year-$monthid-$i";
	$sql0.= 'WHEN "'. $dt. '" THEN "'. $st. '" ';
	$sql1.= 'WHEN "'. $dt. '" THEN "'. $ml. '" ';
	$sql2.= 'WHEN "'. $dt. '" THEN "'. $cl. '" ';
	$sql3.= 'WHEN "'. $dt. '" THEN "'. $fl. '" ';
}
$sql0.= 'END WHERE `pin`="'.$pin.'" AND `date` BETWEEN "'. $startdate . '" AND "' . $enddate . '"; '; 
$sql1.= 'END WHERE `pin`="'.$pin.'" AND `date` BETWEEN "'. $startdate . '" AND "' . $enddate . '"; '; 
$sql2.= 'END WHERE `pin`="'.$pin.'" AND `date` BETWEEN "'. $startdate . '" AND "' . $enddate . '";'; 
$sql3.= 'END WHERE `pin`="'.$pin.'" AND `date` BETWEEN "'. $startdate . '" AND "' . $enddate . '";'; 
$result0 = mysqli_query($link, $sql0);
$result1 = mysqli_query($link, $sql1);
$result2 = mysqli_query($link, $sql2);
$result3 = mysqli_query($link, $sql3);
if(!$result0 or !$result1 or !$result2 or !$result3){
		echo  mysqli_error($link);
}
if($monthid!=1){
	$prevmonth = $monthid-1;
	$sql = 'Update RawMonthTable SET earnedLeave= "'. $balance . '" WHERE pin = "' . $pin . '" AND month = "' . $year . '-' . $prevmonth . '-00"';
	mysqli_query($link, $sql);
}else{
	$prevyear = $year-1;
	$sql = 'Update RawYearTable SET earnedleavebalance= "'. $balance . '" WHERE pin = "' . $pin . '" AND year = "' . $prevyear . '-00-00"';
	mysqli_query($link, $sql);
}
echo $sql;
?>

