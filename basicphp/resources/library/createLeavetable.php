<?php
include 'db.inc.php';
require 'magicquotes.inc.php';
$departmentid = html($_POST['departmentid']);
$staffpin = html($_POST['staffpin']);
$year = html($_POST['year']);
$month = html($_POST['month']);

$sql = "SELECT `name` FROM departments WHERE `id`=$departmentid";
$result = mysqli_query($link, $sql);
if(!$result){
	exit();
}
$row = mysqli_fetch_array($result);
$department = $row['name'];

$sql = "SELECT `name`, `des` FROM RawNameTable WHERE `pin`=$staffpin";
$result = mysqli_query($link, $sql);
if(!$result){
	exit();
}
$row = mysqli_fetch_array($result);
$staffname = $row['name'];
$designation = $row['des'];
$monthid = date("m", strtotime("2015-$month-23"));
$startdate = "$year-$monthid-01";
$endday = date("t", strtotime($startdate));
$enddate = "$year-$monthid-$endday";
$sql = 'SELECT `date` , `inTime` , `outTime` , `status`, `enjoyedleave`, `earnedleave`,
	`medicalleave`,`casualleave`,`leavewithoutpay`'. ' FROM RawTimeTable' . ' WHERE `pin` = "'.$staffpin .'"' . ' AND `date` >= STR_TO_DATE( "'.$year.'-'.$monthid.'-01", "%Y-%m-%d" ) ' . ' AND `date` <= STR_TO_DATE( "'.$year.'-'.$monthid.'-'.$endday.'", "%Y-%m-%d" ) ';
$result = mysqli_query($link, $sql);
if(!$result){
	exit();
}
unset($dates);
while ($row = mysqli_fetch_array($result)){
	$dates[] = $row['date'];
	$today = intval(substr($row['date'],-2));
	$intime[$today] = $row['inTime'];
	$outtime[$today] = $row['outTime'];
	$status[$today] = $row['status'];
	$enjoyedleave[$today] = $row['enjoyedleave'];
	$earnedleave[$today]=$row['earnedleave'];
	$medicalleave[$today]=$row['medicalleave'];
	$casualleave[$today]=$row['casualleave'];
	$leavewithoutpay[$today]=$row['leavewithoutpay'];
	if($intime[$today]!="00:00:00" and $outtime[$today] != "00:00:00"){
		$workhour[$today] = date("g:s", strtotime($outtime[$today])-strtotime($intime[$today]));
	}
}
$sql = 'SELECT `flag`, `date` FROM calendar WHERE `date`>="'.$startdate.'" AND `date`<="'.$enddate.'"';
$result = mysqli_query($link, $sql);
if(!$result){
	exit();
}
while ($row = mysqli_fetch_array($result)){
	$today = intval(substr($row['date'],-2));
	$flags[$today] = $row['flag'];

}
if($monthid != 1){
	$prevmonth = $monthid-1;
	$sql =  'SELECT * FROM RawMonthTable WHERE `pin`="'.$staffpin.'" AND YEAR(`month`)="'.$year.'" AND MONTH(`month`)="'.$prevmonth.'"';
	$result = mysqli_query($link, $sql);
	if(!$result){
		$error = "Error getting month".mysqli_error($link);
		include 'error.html.php';
		exit();
	}
	if($row = mysqli_fetch_array($result)){
		$earn_leave_balance=$row['earnedLeave'];
		$medical_leave_balance=$row['medicalLeave'];
		$casual_leave_balance=$row['casualLeave'];
		$lates = $row['lates'];
		$halves = $row['halves'];
		$absents = $row['absents'];
	}
	if(empty($earn_leave_balance)){
		$earn_leave_balance= '0';
	}
	if(empty($medical_leave_balance)){
		$medical_leave_balance= '0';
	}
	if(empty($casual_leave_balance)){
		$casual_leave_balance= '0';
		$leaves_without_pay = '0'; 
		$lates ='0';
	}
	if(empty($halves)){
		$halves = 0;
	}
	if(empty($absents)){
		$absents = 0;
	}
}else{
	$earn_leave_balance = 12;
	$medical_leave_balance = 14;
	$casual_leave_balance = 21;
	$leaves_without_pay = 0;
	$lates = 0;
	$halves = 0;
	$absents = 0;
}

for($daycounter = "1";$daycounter<=$endday;$daycounter++){
	$days[] = $daycounter;
	$dt = $daycounter<10 ? "$year-$monthid-0$daycounter" : "$year-$monthid-$daycounter";
	$dayNames[$daycounter]=date("l",strtotime($dt));
	if(empty($flags[$daycounter])){
		if($dayNames[$daycounter]  == 'Friday' or $dayNames[$daycounter] == 'Saturday'){
			$flags[$daycounter] = 'holiday';
		}else{
			$flags[$daycounter] = 'workday';
		}
	}
	if(!isset($intime[$daycounter])){
		$intime[$daycounter] = "-";
	}
	if(!isset($outtime[$daycounter])){
		$outtime[$daycounter] = "-";
	}
	if($intime[$daycounter]=="00:00:00"){
		$intime[$daycounter] = "-";
	}
	if($outtime[$daycounter]=="00:00:00"){
		$outtime[$daycounter] = "-";
	}
	if($intime[$daycounter]!="-" and $outtime[$daycounter] != "-"){
		$workhour[$daycounter] = date("G \h i \m", strtotime($outtime[$daycounter])-strtotime($intime[$daycounter]));
	}else{		
		$workhour[$daycounter] = "-";
	}

	if(!isset($medicalleave[$daycounter])){
		$medicalleave[$daycounter]='0';
	}

	if(!isset($casualleave[$daycounter])){
		$casualleave[$daycounter]='0';
	}
	$leavewithoutpay[$daycounter]=0;
	if($intime[$daycounter] == "-" and $flags[$daycounter]!='holiday'){
		$st = 'absent';
		$ste = 'absent';
		$absents++;
	}else if($outtime[$daycounter]=="-" and $flags[$daycounter]!='holiday'){
		$st = 'nopunchout';
		$intime_epoch = strtotime($intime[$daycounter]);
		$entrytime_epoch = strtotime("09:15:00");
		$latetime_epoch = strtotime("09:30:00");
		if($intime_epoch>$latetime_epoch){
			$ste = "half";
			if($halves>=12){
				$ste = "absent";
			}
			$halves++;
		}else if($intime_epoch>$entrytime_epoch){
			$ste = "late";
			$lates++;
			if($lates>=3){
				$ste = 'absent';
				$lates = 0;
			}
		}else{
			$ste = "full";
		}

	}else if($intime[$daycounter] != "-" and $flags[$daycounter]=='holiday'){
		$st = 'pholiday';
		$ste = $st;
	}else if($flags[$daycounter]=='holiday'){
		$st = 'aholiday';
		$ste = $st;
	}else{
		$intime_epoch = strtotime($intime[$daycounter]);
		$outtime_epoch = strtotime($outtime[$daycounter]);
		$entrytime_epoch = strtotime("09:15:00");
		$latetime_epoch = strtotime("09:30:00");
		$leavetime_epoch = strtotime("13:30:00");
		if($intime_epoch>$latetime_epoch or $outtime_epoch<$leavetime_epoch){
			$st = "half";
			if($halves>=12){
				$ste = "absent";
			}
			$halves++;
		}else if($intime_epoch>$entrytime_epoch){
			$st = "late";
			$lates++;
			if($lates>=3){
				$ste = 'absent';
				$lates = 0;
			}
		}else{
			$st = "full";
			$ste = $st;
		}
	}
	$status[$daycounter]=$st;	
	$enjoyedleave[$daycounter] = 0;
	if($ste=='absent'){
		if($medicalleave[$daycounter] and $medical_leave_balance){
			$medical_leave_balance--;
		}else if($casualleave[$daycounter] and $casual_leave_balance){
			$casual_leave_balance--;
		}else  if($earn_leave_balance>=1){
			$enjoyedleave[$daycounter] = 1;
			$earn_leave_balance--;
		}else  if($earn_leave_balance<1 and $earn_leave_balance>=0.5){
			$earn_leave_balance-=0.5;
			$enjoyedleave[$daycounter] = 0.5;
			$leaves_without_pay+=0.5;
			$leavewithoutpay[$daycounter]=0.5;
			$earnedleave[$daycounter] = -0.029;
			$earn_leave_balance-=0.029;
		}else if($earn_leave_balance<0.5){
			$leavewithoutpay[$daycounter]=1;
			$earnedleave[$daycounter] = -0.058;
			$earn_leave_balance-=0.058;
			$leaves_without_pay++;
		}
		$earnedleave[$daycounter]+=0.058;
		$earn_leave_balance+=0.058;
	}else if ($ste=='half'){
		if($medicalleave[$daycounter] and $medical_leave_balance>=0.5){
			$medical_leave_balance-=0.5;
		}else if($casualleave[$daycounter] and $casual_leave_balance>=0.5){
			$casual_leave_balance-=0.5;
		}else if($earn_leave_balance>=0.5){
			$enjoyedleave[$daycounter] = 0.5;
			$earn_leave_balance-=0.5;
		}else if($earn_leave_balance<0.5){
			$leavewithoutpay[$daycounter]=0.5;
			$leaves_without_pay+=0.5;
		}
		$earnedleave[$daycounter] = 0.029;
		$earn_leave_balance += 0.029;
	}else{
		$earnedleave[$daycounter] = 0.058;
		$earn_leave_balance += 0.058;
	}
	$balance[$daycounter]="$earn_leave_balance";
}
?>
