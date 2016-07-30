<article id = "tableholder">
	<table id="leaveTable">
		<caption style="font-size: 1.5em;font-weight:bold;">Leave Report</caption>
		<caption id="month" style="font-size: 1em;font-weight:bold;"><?php echo $month." ".$year;?></caption>
		<tr>
			<td colspan="5" style="text-align:left;border-bottom: 1px solid transparent; border-top: 1px solid transparent;border-left: 1px solid transparent;border-right: 1px solid transparent"><b>Name: </b> <?php echo $staffname;?>
		</tr>
		<tr>
			<td colspan="5" style="text-align:left; border: 1px solid transparent; border-top: 1px solid transparent;border-left: 1px solid transparent;border-right: 1px solid transparent"><b>Designation: </b><?php echo $designation; ?></td>
		<tr>
			<td id = "pin" colspan="5" style="text-align:left;border-bottom: 1px solid transparent; border-top: 1px solid transparent;border-left: 1px solid transparent;border-right: 1px solid transparent"><b>Pin: </b><?php echo sprintf("%08d",$staffpin); ?></td>
		</tr>

			
		</tr>
		<tr>
			<th colspan="5" style="border-left: 1px solid transparent; border-top: 1px solid transparent; border-bottom: 1px solid transparent"></th>
			<th>Month</th>
			<th>Medical Leave</th>
			<th>Casual Leave</th>
			<th>Earned Leave</th>
			<th>Halves</th>
			<th colspan="4"style="border-right: 1px solid transparent; border-top: 1px solid transparent; border-bottom: 1px solid transparent"></th>
		</tr>

		<tr>
			<th colspan="5" style="border-left: 1px solid transparent; border-top: 1px solid transparent; border-bottom: 1px solid transparent"></th>
			<td><?php echo date('F Y', strtotime($prevmonth));?></td>
			<td>
				<div  class="view"><?php echo $prev_medical_leave; ?></div>
				<div class = "edit"><input id="medicalbalance" type="number" value=<?php echo $prev_medical_leave;?> style="width:70px"></div>
			</td><td>
				<div  class="view"><?php echo $prev_casual_leave; ?></div>
				<div class = "edit"><input id="casualbalance" type="number" value=<?php echo $prev_casual_leave;?> style="width:70px"></div>
			</td><td>
				<div  class="view"><?php echo $prev_earned_leave; ?></div>
				<div class = "edit"><input id="earnedbalance" type="number" value=<?php echo $prev_earned_leave;?> style="width:70px"></div>
			</td>
			<td>
				<div  class="view"><?php echo $prev_halves; ?></div>
				<div class = "edit"><input id="halfbalance" type="number" value=<?php echo $prev_halves;?> style="width:70px"></div> 
			</td>
			<th colspan="4" style="border-right: 1px solid transparent; border-top: 1px solid transparent; border-bottom: 1px solid transparent"></th>
		</tr>	
		<tr>
			<td colspan="14"></td>
		</tr>
		<tr>
			<th>Date</th>
			<th>Day</th>
			<th>Flag</th>
			<th>In Time</th>
			<th>Out Time</th>
			<th>Hours Worked</th>
			<th>Status</th>
			<th>Enjoyed Leave</th>
			<th>Casual/Sick Leave</th>
			<th>Medical Leave</th>
			<th>Duty Leave</th>
			<th>Earned Leave</th>
			<th>Without Pay</th>
			<th>Earned Leave Balance</th>
		</tr>
		<?php foreach($days as $index=>$day): ?>
			<tr id="row<?php echo $day;?>" class="datafield">
				<td class="date"><?php echo $day; ?></td>
				<td class="day"><?php echo $dayNames[$day]; ?></td>
				<td class="stat">
					<?php $flag =  strtoupper(substr($flags[$day],0,1));?>
					<div class="view"><?php echo $flag;?></div>
					<div class="edit">
						<input type="radio" name="fl<?php echo $day;?>" value="W" <?php if ($flag=="W"){echo 'checked="true"';}?>>W
						<input type="radio" name="fl<?php echo $day;?>" value="H" <?php if ($flag=="H"){echo 'checked="true"';}?>>H
					</div>
				</td>
				<td class="intime" ><?php echo $intime[$day]; ?></td>
				<td class="outtime"><?php echo $outtime[$day]; ?></td>
				<td class="workhour"><?php echo  $workhour[$day]; ?></td>
				<td class="status">
					<div class="statusview" name="pt<?php echo $day; ?>"><?php echo isset($status[$day]) ? $status[$day] : "-"; ?></div>
		<!--			<div class="edit">
					<select name="pt<?php echo $day;?>">
							<?php $st = $status[$day]; ?>
							<option value="absent" <?php if($st=='absent'){echo 'selected="selectd"';}?>>Absent</option>
							<option value="full" <?php if($st=='full'){echo 'selected="selectd"';}?>>Full</option>
							<Option value="half" <?php if($st=='half'){echo 'selected="selectd"';}?>>Half</option>
							<Option value="late" <?php if($st=='late'){echo 'selected="selectd"';}?>>Late</option>
							<Option value="!out-full" <?php if($st=='!out-full'){echo 'selected="selectd"';}?>>!out-full</option>
							<Option value="!out-half" <?php if($st=='!out-half'){echo 'selected="selectd"';}?>>!out-half</option>
							<Option value="!out-half12" <?php if($st=='!out-half12'){echo 'selected="selectd"';}?>>!out-half&gt;12</option>
							<Option value="!out-late" <?php if($st=='!out-late'){echo 'selected="selectd"';}?>>!out-late</option>
							<Option value="aholiday" <?php if($st=='aholiday'){echo 'selected="selectd"';}?>>A.Holiday</option> 
							<Option value="pholiday" <?php if($st=='pholiday'){echo 'selected="selectd"';}?>>P.Holiday</option>
							<Option value="late3" <?php if($st=='late3'){echo 'selected="selectd"';}?>>Late&gt;3</option>
							<Option value="half12" <?php if($st=='half12'){echo 'selected="selectd"';}?>>Half&gt;12</option>
						</select> 
					</div>-->
				</td>
				<td class="enjoyedleave"><?php echo (float) $enjoyedleave[$day];?></td>
				<td class="casualleave">
					<div class="view"><?php echo (float) $casualleave[$day];?></div>
					<div class="edit">
						<input type="radio" name="cl<?php echo $day;?>" value="1" <?php if ($casualleave[$day]==1){echo 'checked="true"';}?>>1
						<input type="radio" name="cl<?php echo $day;?>" value="0.5" <?php if ($casualleave[$day]==0.5){echo 'checked="true"';}?>>0.5
						<input type="radio" value="0" name="cl<?php echo $day;?>"<?php if ($casualleave[$day]==0){echo 'checked="true"';}?>>0
					</div>
				</td>
				<td class="medicalleave">
					<div class="view"><?php echo (float) $medicalleave[$day];?></div>
					<div class="edit">
						<input type="radio" name="ml<?php echo $day;?>" value="1" <?php if ($medicalleave[$day]==1){echo 'checked="true"';}?>>1
						<input type="radio" name="ml<?php echo $day;?>" value="0.5" <?php if ($medicalleave[$day]==0.5){echo 'checked="true"';}?>>0.5
						<input type="radio" value="0" name="ml<?php echo $day;?>"<?php if ($medicalleave[$day]==0){echo 'checked="true"';}?>>0
					</div>
				</td>
				<td class="dutyleave">
					<div class="view"><?php echo (float) $dutyleave[$day];?></div>
					<div class="edit">
						<input type="radio" name="dl<?php echo $day;?>" value="1" <?php if ($dutyleave[$day]==1){echo 'checked="true"';}?>>1
						<input type="radio" name="dl<?php echo $day;?>" value="0.5" <?php if ($dutyleave[$day]==0.5){echo 'checked="true"';}?>>0.5
						<input type="radio" value="0" name="dl<?php echo $day;?>"<?php if ($dutyleave[$day]==0){echo 'checked="true"';}?>>0
					</div>
				</td>

				<td class="earnedleave"><?php echo (float) $earnedleave[$day];?></td>
				<td class="leavewithoutpay"><?php echo (float) $leavewithoutpay[$day];?></td>
				<td class="balanceleft"><?php echo round($balance[$day], 3);?></td>
			</tr>
		<?php endforeach;?>
		<tr>
			<td>Total</td>
			<td class="day"></td>
			<td class="stat"></td>
			<td class="intime" id="intime" value="10:55"></td>
			<td class="outtime" id="outtime" value=<?php echo $intime[$day]; ?>></td>
			<td class="workhour"><?php echo floor($total_work_hour/3600).' h '. floor(($total_work_hour % 3600)/60). ' m';?></td>
			<td class="status"></td>
			<td class="enjoyedleave"><?php echo array_sum($enjoyedleave); ?></td>
			<td class="casualleave"><?php echo $prev_casual_leave-$casual_leave_balance; ?></td>
			<td class="medicalleave"><?php echo $prev_medical_leave-$medical_leave_balance; ?></td>
			<td class="dutyleave"><?php echo array_sum($dutyleave); ?></td>
			<td class="earnedleave"><?php echo array_sum($earnedleave);?></td>
			<td class="leavewithoutpay"><?php echo $leaves_without_pay;?></td>
			<td class="balanceleft"><?php echo round($earned_leave_balance,3); ?></td>
		</tr>
		<tr>
			<td colspan="5" style="border: 1px solid transparent"></td>
			<td colspan="5"style="border-right: 1px solid transparent"></td>
			<td colspan="4" style="border: 1px solid transparent"></td>
		</tr>
		<tr>
			<th colspan="5" style="border-left: 1px solid transparent; border-top: 1px solid transparent; border-bottom: 1px solid transparent"></th>
			<th>Month</th>
			<th>Medical Leave</th>
			<th>Casual Leave</th>
			<th>Earned Leave</th>
			<th>Halves</th>
			<th colspan="4"style="border-right: 1px solid transparent; border-top: 1px solid transparent; border-bottom: 1px solid transparent"></th>
		</tr>

		<tr>
			<th colspan="5" style="border-left: 1px solid transparent; border-top: 1px solid transparent; border-bottom: 1px solid transparent"></th>
			<td><?php echo date('F Y', strtotime("$year-$monthid-01"));?></td>
			<td>
				<div ><?php echo $medical_leave_balance; ?></div>
			</td>
		    <td>
				<div ><?php echo $casual_leave_balance; ?></div>
			</td>
		    <td>
				<div ><?php echo $earned_leave_balance; ?></div>
			</td>
			<td>
				<div ><?php echo $halves; ?></div>
			</td>
			<th colspan="4" style="border-right: 1px solid transparent; border-top: 1px solid transparent; border-bottom: 1px solid transparent"></th>
		</tr>	
		<tr class="buttonrow">
			<td colspan="2"></td>
			<td>	
				<button type="submit" value="viewLeave" id="resetcalendar" form="search" name="action">Load Pristine Calendar</button>
			</td>
		    <td colspan="2"> </td>
<!--
			<td>	
				<button type="submit" value="viewLeave" id="reset" form="search" name="action">Refresh</button>
			</td>
-->
			<td><button type="button" id="edit">Edit</button></td>
			<td colspan="3">
			<td><button type="button" form="search" name="action" value="viewLeave" id="update">Update</button></td>
		</tr>
	</table>
	<br><br>
	<div id="tmp"></div>
</article>	

<link rel="stylesheet" type="text/css" href="css/viewleave.css" >
<script src="js/viewleave.js"></script>
