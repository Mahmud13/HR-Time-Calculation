<?php
include 'db.inc.php';
require 'magicquotes.inc.php';
$departmentid = html($_POST['departmentid']);
$staffpin = html($_POST['staffpin']);
$year = html($_POST['year']);
$month = html($_POST['month']);
if(isset($_POST['autoMan']) and $_POST['autoMan']=="1"){
	$automan =  "1";
	unset($_POST['autoMan']);
}else{
	$automan = "0";
}
if(isset($_POST['autoCal']) and $_POST['autoCal']=="1"){
	$autocal =  "1";
	unset($_POST['autoCal']);
}else{
	$autocal = "0";
}
//Get the name of the department
$sql = "SELECT `name` FROM departments WHERE `id`=$departmentid";
$result = mysqli_query($link, $sql);
if(!$result){
	exit();
}
$row = mysqli_fetch_array($result);
$department = $row['name'];

//Get name and Designation of the empolyee from database
$sql = "SELECT `name`, `des` FROM RawNameTable WHERE `pin`=$staffpin";
$result = mysqli_query($link, $sql);
if(!$result){
	exit();
}
$row = mysqli_fetch_array($result);
$staffname = $row['name'];
$designation = $row['des'];

//Get month number from the name of the month and the length of the month
$monthid = date("m", strtotime("2015-$month-01"));
$startdate = "$year-$monthid-01";
$length_of_month = date("t", strtotime($startdate));
$enddate = "$year-$monthid-$length_of_month";


//Get the data for everyday of the month
$sql = 'SELECT `date` , `inTime` , `outTime` , `status`, `enjoyedleave`, `earnedleave`, `dutyleave`,
	`medicalleave`,`casualleave`,`leavewithoutpay`'. ' FROM RawTimeTable' . ' WHERE `pin` = "'.$staffpin .'"' . ' AND `date` >= STR_TO_DATE( "'.$year.'-'.$monthid.'-01", "%Y-%m-%d" ) ' . ' AND `date` <= STR_TO_DATE( "'.$year.'-'.$monthid.'-'.$length_of_month.'", "%Y-%m-%d" ) ';
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
	$dutyleave[$today] = $row['dutyleave'];
	if($intime[$today]!="00:00:00" and $outtime[$today] != "00:00:00"){
		$workhour[$today] = date("g:s", strtotime($outtime[$today])-strtotime($intime[$today]));
	}
}

//Get the status of the day where it's a holiday or workday

// Take the data from the pristine calander when reset button is pressed
if($autocal == 1){
	$sql = 'SELECT `flag`, `date` FROM calendar WHERE `date`>="'.$startdate.'" AND `date`<="'.$enddate.'"';
}else{
	$sql = 'SELECT `flag`, `date` FROM RawTimeTable WHERE `pin`="'.$staffpin.'" AND `date`>="'.$startdate.'" AND `date`<="'.$enddate.'"';
}
$result = mysqli_query($link, $sql);
if(!$result){
	exit();
}
while ($row = mysqli_fetch_array($result)){
	$today = intval(substr($row['date'],-2));
	$flags[$today] = $row['flag'];
}
if(isset($flags)){
	$sql = 'SELECT `flag`, `date` FROM calendar WHERE `date`>="'.$startdate.'" AND `date`<="'.$enddate.'"';
	$result = mysqli_query($link, $sql);
	while ($row = mysqli_fetch_array($result)){
		$today = intval(substr($row['date'],-2));
		$flags[$today] = $row['flag'];
	}
}

//Get the balance of the previous month if the month is not January
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
		$earned_leave_balance=$row['earnedLeave'];
		$medical_leave_balance=$row['medicalLeave'];
		$casual_leave_balance=$row['casualLeave'];
		$halves = $row['halves'];
		$absents = $row['absents'];
	}
	if(empty($earned_leave_balance)){
		$earned_leave_balance= '0';
	}
	if(empty($medical_leave_balance)){
		$medical_leave_balance= '0';
	}
	if(empty($casual_leave_balance)){
		$casual_leave_balance= '0';
	}
	if(empty($halves)){
		$halves = 0;
	}
	if(empty($absents)){
		$absents = 0;
	}
}else{
	//If the month is January get the earned leave balance from December of the previous year
	$prevyear = $year-1;
	$sql = "SELECT `earnedleavebalance` FROM RawYearTable WHERE pin=$staffpin AND YEAR(`year`)=$prevyear";
	$result = mysqli_query($link, $sql);
	if(!$result){
		$error = "unable to get year balance" . mysqli_error($link);
		include 'error.html.php';
		exit();
	}
	if($row=mysqli_fetch_array($result)){
		$earned_leave_balance = $row['earnedleavebalance'];
	}
	if(empty($earned_leave_balance)){
		$earned_leave_balance = 0;
	}
	$medical_leave_balance = 14;
	$casual_leave_balance = 21;
	$halves = 0;
	$absents = 0;
}
$prev_earned_leave = $earned_leave_balance;
$prev_medical_leave = $medical_leave_balance;
$prev_casual_leave = $casual_leave_balance;
$prev_halves = $halves;
$adjusted_earned_leave_balance = $earned_leave_balance + 1.75;
$lates = 0;
$leaves_without_pay = '0'; 
$total_work_hour = date(strtotime('0'));
//Evaluate the parameters of each day of the month
$sql = 'INSERT IGNORE INTO RawTimeTable (`pin`, `date`, `inTime`, `outTime`, `status`, `medicalleave`, `casualleave`, `enjoyedleave`, `earnedleave`, `dutyleave`, `leavewithoutpay`)
VALUES ';

for($day = "1";$day<=$length_of_month;$day++){
	$days[] = $day;
	$date = $day<10 ? "$year-$monthid-0$day" : "$year-$monthid-$day";
	$dayNames[$day]=date("l",strtotime($date));
	//If flag of the day is not available from the pristine calendar, assign default flags
	if(empty($flags[$day])){
		if($dayNames[$day]  == 'Friday' or $dayNames[$day] == 'Saturday'){
			$flags[$day] = 'holiday';
		}else{
			$flags[$day] = 'workday';
		}
	}
	//No inTime or outTime data are availabe for the day e.g. a holiday
	if(!isset($intime[$day])){
		$intime[$day] = "-";
	}
	if(!isset($outtime[$day])){
		$outtime[$day] = "-";
	}
	//The null flag is selected as "-00:00:01"
	if($intime[$day]=="-00:00:01"){
		$intime[$day] = "-";
	}
	if($outtime[$day]=="-00:00:01"){
		$outtime[$day] = "-";
	}
	//If both inTime and outTime is available, determine the workhour
	if($intime[$day]!="-" and $outtime[$day] != "-"){
		$workhour[$day] = date("G \h i \m", strtotime($outtime[$day])-strtotime($intime[$day]));
		$total_work_hour = date($total_work_hour+strtotime($outtime[$day])-strtotime($intime[$day])); 
	}else{		
		$workhour[$day] = "-";
	}

	if(!isset($medicalleave[$day])){
		$medicalleave[$day]='0';
	}

	if(!isset($casualleave[$day])){
		$casualleave[$day]='0';
	}
	$leavewithoutpay[$day]='0';


	// Calculating day status
	if($intime[$day] == "-" and $flags[$day]!='holiday'){
		$present = 'absent';
	}else if($outtime[$day]=="-" and $flags[$day]!='holiday'){
		$intime_epoch = strtotime($intime[$day]);
		$entrytime_epoch = strtotime("09:15:00");
		$latetime_epoch = strtotime("09:30:00");
		if($intime_epoch>$latetime_epoch){
			$present = "!out-half";
			if($halves>=12){
				$present = "!out-half12";
			}
			$halves++;
		}else if($intime_epoch>$entrytime_epoch){
			$present = "!out-late";
			$lates++;
			if($lates>=3){
				$present= '!out-late3';
				$lates = 0;
			}
		}else{
			$present = '!out-full';
		}

	}else if($intime[$day] != "-" and $flags[$day]=='holiday'){
		$present = 'pholiday';
	}else if($flags[$day]=='holiday'){
		$present = 'aholiday';
	}else{
		$intime_epoch = strtotime($intime[$day]);
		$outtime_epoch = strtotime($outtime[$day]);
		$entrytime_epoch = strtotime("09:15:00");
		$latetime_epoch = strtotime("09:30:00");
		$leavetime_epoch = strtotime("13:30:00");
		if($intime_epoch>$latetime_epoch or $outtime_epoch<$leavetime_epoch){
			$present = "half";
			if($halves>=12){
				$present = "half12";
			}
			$halves++;
		}else if($intime_epoch>$entrytime_epoch){
			$present = 'late';	
			$lates++;
			if($lates>=3){
				$present = 'late3';
				$lates=0;
			}
		}else{
			$present = 'full';
		}
	}
	// take either auto-determined value or the manually set value
	$status[$day] = $present;
	
	// Leave calculation
	$enjoyedleave[$day] = 0;
	$earnedleave[$day] = 0;
	if(in_array($present, array('absent', 'half12', 'late3','!out-half12','!out-late3'))){
		if($medicalleave[$day]==0.5 and $medical_leave_balance>=0.5){
			$medical_leave_balance-=0.5;
			if($earned_leave_balance>=0.5){
				$enjoyedleave[$day] = 0.5;
				$earned_leave_balance-=0.5;
				$adjusted_earned_leave_balance-=0.5;
			}else{
				$leavewithoutpay[$day] = 0.5;
				$leaves_without_pay+=0.5;
			}
		}else if($medicalleave[$day]==1 and $medical_leave_balance>=1){
			$medical_leave_balance--;
		}else if($casualleave[$day]==0.5 and $casual_leave_balance>=0.5){
			$casual_leave_balance-=0.5;
			if($earned_leave_balance>=0.5){
				$enjoyedleave[$day] = 0.5;
				$earned_leave_balance-=0.5;
				$adjusted_earned_leave_balance-=0.5;
			}else{
				$leavewithoutpay[$day] = 0.5;
				$leaves_without_pay+=0.5;
			}
		}else if($casualleave[$day]==1 and $casual_leave_balance>=1){
			$casual_leave_balance--;
		}else  if($earned_leave_balance>=1){
			$enjoyedleave[$day] = 1;
			$earned_leave_balance--;
		    $adjusted_earned_leave_balance--;
		}else if($dutyleave[$day]==0.5){
			if($earned_leave_balance>=0.5){
				$enjoyedleave[$day] = 0.5;
				$earned_leave_balance-=0.5;
				$adjusted_earned_leave_balance-=0.5;
			}else{
				$leavewithoutpay[$day] = 0.5;
				$leaves_without_pay+=0.5;
			}
		}else if($dutyleave[$day]==1){
		}else  if($earned_leave_balance>=1){
			$enjoyedleave[$day] = 1;
			$earned_leave_balance--;
		    $adjusted_earned_leave_balance--;
		}else  if($earned_leave_balance<1 and $earned_leave_balance>=0.5){
			$earned_leave_balance-=0.5;
			$enjoyedleave[$day] = 0.5;
			$leaves_without_pay+=0.5;
			$leavewithoutpay[$day]=0.5;
			$earnedleave[$day] = -0.029;
			$earned_leave_balance-=0.029;
		    $adjusted_earned_leave_balance-=0.529;
		}else if($earned_leave_balance<0.5){
			$leavewithoutpay[$day]=1;
			$earnedleave[$day] = -0.058;
			$earned_leave_balance-=0.058;
			$leaves_without_pay++;
			$adjusted_earned_leave_balance-=0.058;
		}
		$earnedleave[$day]+=0.058;
		$earned_leave_balance+=0.058;
	}else if ($present=='half' or $present=='!out-half'){
		echo 'kake samlabo ';
		echo $dutyleave[$day];
		if($medicalleave[$day]==0.5 and $medical_leave_balance>=0.5){
			$medical_leave_balance-=0.5;
		}else if($casualleave[$day]==0.5 and $casual_leave_balance>=0.5){
			$casual_leave_balance-=0.5;
		}else if($dutyleave[$day]==0.5){
		    echo "samlao";
		}else if($earned_leave_balance>=0.5){
			$enjoyedleave[$day] = 0.5;
			$earned_leave_balance-=0.5;
			$adjusted_earned_leave_balance-=0.5;
		}else{
			$leavewithoutpay[$day]=0.5;
			$leaves_without_pay+=0.5;
			$earnedleave[$day] = -0.029;
			$earned_leave_balance -= 0.029;
			$adjusted_earned_leave_balance-=0.029;
		}
		$earnedleave[$day] += 0.058;
		$earned_leave_balance += 0.058;
	}else{
		$earnedleave[$day] = 0.058;
		$earned_leave_balance += 0.058;
	}
	$balance[$day]="$earned_leave_balance";
	$dt = "$year-$monthid-$day";
	$sql .= "($staffpin, '" . $dt . "', '-00:00:01', '-00:00:01', NULL, '0', '0', '0', '0', '0', '0'),";
}
$sql = rtrim($sql, ',') . ';';
$result = mysqli_query($link, $sql);
if($adjusted_earned_leave_balance-$prev_earned_leave<1.75){
	$adjusted_earned_leave_balance-=0.01;
}
$earned_leave_balance = $adjusted_earned_leave_balance;
//Store the month-end balances to the month table
if($monthid==12 and $earned_leave_balance>60){
	$earned_leave_balance = 60;
}
$sql = 'SELECT `pin` FROM RawMonthTable WHERE `pin`="'.$staffpin.'" AND `month`="'.$year.'-'.$monthid.'-00"';
$result = mysqli_query($link, $sql);
if(!$result){
	$error = "Cannot connect to month". mysqli_error($link);
	include 'error.html.php';
	exit();
}
$row = mysqli_fetch_array($result);
if(empty($row)){
	$sql = 'INSERT INTO RawMonthTable(pin, month, lates, halves, absents, casualLeave, medicalLeave, earnedLeave, leaveswithoutpay)
				VALUES("'.$staffpin.'","'.$year.'-'.$monthid.'-00","'.$lates.'","'.$halves.'","'.$absents.'","'.$casual_leave_balance.'","'.$medical_leave_balance.'","'.$earned_leave_balance.'","'.$leaves_without_pay.'")';
}else{
	$mn = "$year-$monthid-00";
	$sql = 'UPDATE RawMonthTable
			SET 
			`lates`="' . $lates . '", `halves`="' . $halves . '", `absents` = "' . $absents . '",
			`casualLeave` = "' . $casual_leave_balance . '", `medicalLeave`= "' . $medical_leave_balance . '",
			`earnedLeave` = "' . $earned_leave_balance . '", `leaveswithoutpay`= "' . $leaves_without_pay . '"
			WHERE `pin`= "' . $staffpin . '" AND `month`="'. $mn . '"';
}
$result = mysqli_query($link, $sql);
if(!$result){
	$error ="cannot store value. ". mysqli_error($link);
	include 'error.html.php';
    exit();
}
?>
