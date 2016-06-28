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
	$monthid = date("m", strtotime($month));
	$startdate = "$year-$monthid-01";
	$endday = cal_days_in_month(CAL_GREGORIAN, $monthid, $year);
	$enddate = "$year-$monthid-$endday";
	$sql = 'SELECT `date` , `inTime` , `outTime` '. ' FROM RawTimeTable' . ' WHERE `pin` = "'.$staffpin .'"' . ' AND `date` >= STR_TO_DATE( "'.$year.'-'.$monthid.'-01", "%Y-%m-%d" ) ' . ' AND `date` <= STR_TO_DATE( "'.$year.'-'.$monthid.'-'.$endday.'", "%Y-%m-%d" ) ';
	$result = mysqli_query($link, $sql);
	if(!$result){
		exit();
	}
	while ($row = mysqli_fetch_array($result)){
		$dates[] = $row['date'];
		$today = intval(substr($row['date'],-2));
		$intime[$today] = $row['inTime'];
		$outtime[$today] = $row['outTime'];
	}
	for($daycounter = "1";$daycounter<=$endday;$daycounter++){
		$days[] = $daycounter;
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
	}
	$sql = 'SELECT `flag` FROM calendar WHERE `date`>="'.$startdate.'" AND `date`<="'.$enddate.'"';
	$result = mysqli_query($link, $sql);
	if(!$result){
		exit();
	}
	while ($row = mysqli_fetch_array($result)){
		$flags[] = $row['flag'];
	}
 ?>
