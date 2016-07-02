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
