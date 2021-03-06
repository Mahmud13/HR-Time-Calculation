<?php
include "../config.php";
include 'db.inc.php';
if(!isset($_POST['medicalleave']) or !isset($_POST['month']) or !isset($_POST['pin']) or !isset($_POST['dutyleave'])){
	echo 'error';
	exit();	
}

$flags = $_POST['flag'];
$status = $_POST['status'];
$medicalleave = $_POST['medicalleave'];
$casualleave = $_POST['casualleave'];
$dutyleave = $_POST['dutyleave'];
$len = count($flags)-1;
$month = explode(' ', $_POST['month'] );
$year = $month[1];
$month = $month[0];
$monthid = date("m", strtotime("2015-$month-01"));
$pin = $_POST['pin'];
$startdate = "$year-$monthid-01";
$enddate = "$year-$monthid-$len";
$medicalbalance = $_POST['medicalbalance'];
$casualbalance = $_POST['casualbalance'];
$earnedbalance = $_POST['earnedbalance'];
$halfbalance = $_POST['halfbalance'];
$sql0 = 'UPDATE RawTimeTable SET `status` = CASE date ';
$sql1 = 'UPDATE RawTimeTable SET `medicalleave` = CASE date ';
$sql2 = 'UPDATE RawTimeTable SET `casualleave` = CASE date ';
$sql3 = 'UPDATE RawTimeTable SET `flag` = CASE date ';
$sql4 = 'UPDATE RawTimeTable SET `dutyleave` = CASE date ';
for($i=1; $i<=$len; $i++){
	$st = $status[$i];
	$ml = $medicalleave[$i];
	$cl = $casualleave[$i];
	$fl = $flags[$i]=='W' ? 'workday' : 'holiday';
	$dl = $dutyleave[$i];
	$dt = $i<10 ? "$year-$monthid-0$i" : "$year-$monthid-$i";
	if($fl=='H'){
		 $ml = 0;
		 $cl = 0;
		 $dl = 0;
	 }
    if(in_array($st, array('half', '!out-half'))){
  		 if($ml==1){
  			 $ml = 0.5;
  			 $cl = 0;
  			 $dl = 0;
  		 }else if($ml == 0.5){
  			 $cl = 0;
  			 $dl = 0;
  		 }
  		 if($cl==1){
  			 $cl = 0.5;
  			 $ml = 0;
  			 $dl = 0;
  		 }else if($cl == 0.5){
  			 $ml = 0;
  			 $dl = 0;
  		 }	
  		 if($dl==1){
  			 $dl = 0.5;
  			 $ml = 0;
  			 $cl = 0;
  		 }else if($dl==0.5){
  			 $ml = 0;
  			 $cl = 0;
  		 }
  	 }else if(in_array($st, array('absent', 'half12', 'late3','!out-half12','!out-late3'))){
		 if($ml>0){
			 $cl = 0;
			 $dl = 0;
		 }
		 if($cl>0){
			 $ml = 0;
			 $dl = 0;
		 }
		 if($dl>0){
			 $ml = 0;
			 $cl = 0;
		 }
    }else if($st=='full'){
		 $dl = 0;
		 $ml = 0;
		 $cl = 0;
	}
	$sql0.= 'WHEN "'. $dt. '" THEN "'. $st. '" ';
	$sql1.= 'WHEN "'. $dt. '" THEN "'. $ml. '" ';
	$sql2.= 'WHEN "'. $dt. '" THEN "'. $cl. '" ';
	$sql3.= 'WHEN "'. $dt. '" THEN "'. $fl. '" ';
	$sql4.= 'WHEN "'. $dt. '" THEN "'. $dl. '" ';
}

$sql0.= 'END WHERE `pin`="'.$pin.'" AND `date` BETWEEN "'. $startdate . '" AND "' . $enddate . '"; '; 
$sql1.= 'END WHERE `pin`="'.$pin.'" AND `date` BETWEEN "'. $startdate . '" AND "' . $enddate . '"; '; 
$sql2.= 'END WHERE `pin`="'.$pin.'" AND `date` BETWEEN "'. $startdate . '" AND "' . $enddate . '";'; 
$sql3.= 'END WHERE `pin`="'.$pin.'" AND `date` BETWEEN "'. $startdate . '" AND "' . $enddate . '";'; 
$sql4.= 'END WHERE `pin`="'.$pin.'" AND `date` BETWEEN "'. $startdate . '" AND "' . $enddate . '";'; 
$result0 = mysqli_query($link, $sql0);
$result1 = mysqli_query($link, $sql1);
$result2 = mysqli_query($link, $sql2);
$result3 = mysqli_query($link, $sql3);
$result4 = mysqli_query($link, $sql4);
if(!$result4 or !$result1 or !$result2 or !$result3){
	echo  mysqli_error($link);
}
if($monthid != 1){
		$prevmonth = $monthid<10 ? $year . '-0' . ($monthid-1) . '-01' : $year . '-' . ($monthid-1) . '-01';
}else{
		$prevmonth = $year-1 . '-12-01';
}
$sql = 'INSERT INTO RawMonthTable(pin, month, halves, medicalLeave, casualLeave, earnedLeave) VALUES("' . $pin . '", "'. $prevmonth . '", "'. $halfbalance . '", "'. $medicalbalance . '", "' . $casualbalance . '", "' . $earnedbalance . '") ON DUPLICATE KEY UPDATE halves = "' . $halfbalance . '", medicalLeave= "'. $medicalbalance . '" , casualLeave= "'. $casualbalance . '", earnedLeave= "'. $earnedbalance . '";';
mysqli_query($link, $sql);
echo $sql;
?>
