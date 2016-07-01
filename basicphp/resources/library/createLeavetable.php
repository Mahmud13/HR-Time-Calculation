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
	$sql = 'SELECT `date` , `inTime` , `outTime` , `status`'. ' FROM RawTimeTable' . ' WHERE `pin` = "'.$staffpin .'"' . ' AND `date` >= STR_TO_DATE( "'.$year.'-'.$monthid.'-01", "%Y-%m-%d" ) ' . ' AND `date` <= STR_TO_DATE( "'.$year.'-'.$monthid.'-'.$endday.'", "%Y-%m-%d" ) ';
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
		if($intime[$today]!="00:00:00" and $outtime[$today] != "00:00:00"){
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
	for($daycounter = "1";$daycounter<=$endday;$daycounter++){
		$days[] = $daycounter;
		$dt = $daycounter<10 ? "$year-$monthid-0$daycounter" : "$year-$monthid-$daycounter";
		if(!in_array($dt,$dates)){
			$sql = 'INSERT INTO RawTimeTable
					SET
					`status`="holiday",
					`intime`="00:00:00",
					`outtime`="00:00:00",
					`pin`="'.$staffpin.'",
					`date`="'.$dt.'"';
			mysqli_query($link, $sql);
		}
		$dayNames[$daycounter] = date("l", strtotime("$year-$monthid-$daycounter"));
		if(empty($flags[$daycounter])){
			if($dayNames[$daycounter]!='Friday' and $dayNames[$daycounter]!='Saturday'){
				$flags[$daycounter]='workday';
			}else{
				$flags[$daycounter]='holiday';
			}
			$sql = 'INSERT INTO calendar
					SET
					`epochdate`="'.strtotime($dt).'",
					`flag`="'.$flags[$daycounter].'",
					`date`="'.$dt.'"';
			mysqli_query($link, $sql);
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
		if(!isset($status[$daycounter]) or is_null($status[$daycounter])){
			if($intime[$daycounter] == "-" and $flags[$daycounter]!='holiday'){
				$st = 'absent';
			}else if($outtime[$daycounter]=="-" and $flags[$daycounter]!='holiday'){
				$st = 'nopunchout';
			}else if($flags[$daycounter]=='holiday'){
				$st = 'holiday';
			}else{
				$intime_epoch = strtotime($intime[$daycounter]);
				$outtime_epoch = strtotime($outtime[$daycounter]);
				$entrytime_epoch = strtotime("09:15:00");
				$latetime_epoch = strtotime("09:30:00");
				$leavetime_epoch = strtotime("13:30:00");
				if($intime_epoch>$latetime_epoch or $outtime_epoch<$leavetime_epoch){
					$st = "half";
				}else if($intime_epoch>$entrytime_epoch){
					$st = "late";
				}else{
					$st = "full";
				}
			}
			$status[$daycounter] = $st;
			$sql = 'UPDATE RawTimeTable
					SET `status`="'.$st.'"
					WHERE `pin`="'.$staffpin.'" AND `date`="'.$dt.'"';
			mysqli_query($link, $sql);
		}
	}
?>
