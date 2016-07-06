<style>
.buttonrow{
	height: 50px;
}
.buttonrow td{
 	border: 1px solid transparent;
 	border-top: 1px solid black;
}
.buttonrow td button{
	font-weight: bold;
}

</style>
<article id = "tableholder">
	<table id="leaveTable">
		<caption style="font-size: 1.5em;font-weight:bold;">Leave Report</caption>
		<caption id="month" style="font-size: 1em;font-weight:bold;"><?php echo $month." ".$year;?></caption>
		<tr>
			<td colspan="7" style="text-align:left;border-top: 1px solid transparent;border-left: 1px solid transparent;border-right: 1px solid transparent"><b>Name: </b> <?php echo $staffname;?><br><b>Designation: </b><?php echo $designation; ?></td>
			<td id="pin" colspan="6" style="text-align:right;border-top: 1px solid transparent;border-left: 1px solid transparent;border-right: 1px solid transparent"><b>Pin: </b><?php echo sprintf("%08d",$staffpin); ?></td>
		</tr>
		<tr>
			<th>Date</th>
			<th>Day</th>
			<th>Status</th>
			<th>In Time</th>
			<th>Out Time</th>
			<th>Hours Worked</th>
			<th>Present Type</th>
			<th>Enjoyed Leave</th>
			<th>Casual/Sick Leave</th>
			<th>Medical Leave</th>
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
					<div class="view"><?php echo isset($status[$day]) ? $status[$day] : "-"; ?></div>
					<div class="edit">
						<select name="pt<?php echo $day;?>">
							<?php $st = $status[$day]; ?>
							<option value="absent" <?php if($st=='absent'){echo 'selected="selectd"';}?>>Absent</option>
							<option value="full" <?php if($st=='full'){echo 'selected="selectd"';}?>>Full</option>
							<Option value="half" <?php if($st=='half'){echo 'selected="selectd"';}?>>Half</option>
							<Option value="late" <?php if($st=='late'){echo 'selected="selectd"';}?>>Late</option>
							<Option value="!out-full" <?php if($st=='!out-full'){echo 'selected="selectd"';}?>>!out-full</option>
							<Option value="!out-half" <?php if($st=='!out-half'){echo 'selected="selectd"';}?>>!out-half</option>
							<Option value="!out-late" <?php if($st=='!out-late'){echo 'selected="selectd"';}?>>!out-late</option>
							<Option value="aholiday" <?php if($st=='aholiday'){echo 'selected="selectd"';}?>>A.Holiday</option>
							<Option value="pholiday" <?php if($st=='pholiday'){echo 'selected="selectd"';}?>>P.Holiday</option>
							<Option value="late3" <?php if($st=='late3'){echo 'selected="selectd"';}?>>Late&gt;3</option>
							<Option value="half12" <?php if($st=='half12'){echo 'selected="selectd"';}?>>Half&gt;12</option>
						</select>
					</div>
				</td>
				<td class="enjoyedleave"><?php echo (float) $enjoyedleave[$day];?></td>
				<td class="casualleave">
					<div class="view"><?php echo (float) $casualleave[$day];?></div>
					<div class="edit">
						<input type="radio" name="cl<?php echo $day;?>" value="1" <?php if ($casualleave[$day]==1){echo 'checked="true"';}?>>y
						<input type="radio" value="0" name="cl<?php echo $day;?>"<?php if ($casualleave[$day]==0){echo 'checked="true"';}?>>n
					</div>
				</td>
				<td class="medicalleave">
					<div class="view"><?php echo (float) $medicalleave[$day];?></div>
					<div class="edit">
						<input type="radio" name="ml<?php echo $day;?>" value="1" <?php if ($medicalleave[$day]==1){echo 'checked="true"';}?>>y
						<input type="radio" value="0" name="ml<?php echo $day;?>"<?php if ($medicalleave[$day]==0){echo 'checked="true"';}?>>n
					</div>
				</td>
				<td class="earnedleave"><?php echo (float) $earnedleave[$day];?></td>
				<td class="leavewithoutpay"><?php echo (float) $leavewithoutpay[$day];?></td>
				<td class="balanceleft"><?php echo  $balance[$day];?></td>
			</tr>
		<?php endforeach;?>
		<tr>
			<td>Total</td>
			<td class="day"></td>
			<td class="stat"></td>
			<td class="intime" id="intime" value="10:55"></td>
			<td class="outtime" id="outtime" value=<?php echo $intime[$day]; ?>></td>
			<td class="workhour"></td>
			<td class="status"></td>
			<td class="earnedleave"></td>
			<td class="casualleave"></td>
			<td class="medicalleave"></td>
			<td class="enjoyedleave"></td>
			<td class="leavewithoutpay"><?php echo $leaves_without_pay;?></td>
			<td class="balanceleft"></td>
		</tr>
		<tr class="buttonrow">
			<td colspan="5"></td>
			<td>	
				<button type="submit" value="viewLeave" id="reset" form="search" name="action">Reset</button>
			</td>
			<td><button type="button" id="edit">Edit</button></td>
			<td colspan="2">
			<td><button type="button" id="update">Update</button></td>
		</tr>
	</table>
	<br><br>
</article>	
<script>
$(document).ready( function(){
		var scrollToElement = $("#leaveTable");
		$(window).scrollTop( scrollToElement.offset().top);
//		$("#update").attr("disabled",true);
		//$("#reset").attr("disabled",true);
		$(".edit").hide();
});
$("#edit").click(function(){
		$(".edit").show();
		$(".view").hide();
		$("#edit").attr("disabled",true);
		$("#update").removeAttr("disabled");
		$("#reset").removeAttr("disabled");
});
$("#update").click(function(){
	var flags = [];
	var presentType = [];
	var medicalVal = [];
	var casualVal = [];
	var month = $("#month").html(); 
	var pin = $("#pin").html(); 
	var pin = parseInt(pin.substring(pin.length-8,pin.length));
	$(".datafield").each(function(){
			var day = parseInt($(this).attr("id").substring(3,5));
			flags[day] = $(this).find("input[name='fl"+day+"']:checked").val();
			presentType[day] = $(this).find("select[name='pt"+day+"'] option:selected").val();
			medicalVal[day] = $(this).find("input[name='ml"+day+"']:checked").val();
			casualVal[day] = $(this).find("input[name='cl"+day+"']:checked").val();
	});
	$.ajax({
			url: 'resources/library/editLeaveTable.php',
			type: 'POST',
			data: {flag: flags, status: presentType, medicalleave: medicalVal, casualleave: casualVal, pin: pin, month: month},
			success: function(data){
				$("#tmp").html(data);
			}
	});	  
	location.reload();
});
$("#reset").click(function(){
	$("#automan").val("1");
	$("#update").removeAttr("disabled");
});
</script>
