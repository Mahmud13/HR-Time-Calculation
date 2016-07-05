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
		<caption style="font-size: 1em;font-weight:bold;"><?php echo $month." ".$year;?></caption>
		<tr>
			<td colspan="7" style="text-align:left;border-top: 1px solid transparent;border-left: 1px solid transparent;border-right: 1px solid transparent"><b>Name: </b> <?php echo $staffname;?><br><b>Designation: </b><?php echo $designation; ?></td>
			<td colspan="6" style="text-align:right;border-top: 1px solid transparent;border-left: 1px solid transparent;border-right: 1px solid transparent"><b>Pin: </b><?php echo sprintf("%08d",$staffpin); ?></td>
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
		<form method="post" action="update_data.php">
		<?php foreach($days as $index=>$day): ?>
			<tr id="row<?php echo $day;?>" class="datafield">
				<td class="date"><?php echo $day; ?></td>
				<td class="day"><?php echo $dayNames[$day]; ?></td>
				<td class="stat"><?php echo strtoupper(substr($flags[$day],0,1));?></td>
				<td class="intime" id="intime" value="10:55"><?php echo $intime[$day]; ?></td>
				<td class="outtime" id="outtime" value=<?php echo $intime[$day]; ?>><?php echo $outtime[$day]; ?></td>
				<td class="workhour"><?php echo  $workhour[$day]; ?></td>
				<td class="status"><?php echo isset($status[$day]) ? $status[$day] : "-"; ?></td>
				<td class="enjoyedleave"><?php echo (float) $enjoyedleave[$day];?></td>
				<td class="casualleave"><?php echo (float) $casualleave[$day];?></td>
				<td class="medicalleave"><div class="view"><?php echo (float) $medicalleave[$day];?></div><div class="edit"><input type="radio" name="ml<?php echo $day;?>" value="1" <?php if ($medicalleave[$day]==1){echo 'checked="true"';}?>>y<input type="radio" value="0" name="ml<?php echo $day;?>"<?php if ($medicalleave[$day]==0){echo 'checked="true"';}?>>n</div></td>
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
			<td><button type="button" id="reset">Reset</button></td>
			<td><button type="button" id="edit">Edit</button></td>
			<td><button type="submit" id = "update">Update</button></td>
		</tr>
		</form>
	</table>
	<br><br>
</article>	
<script>
$(document).ready( function(){
		var scrollToElement = $("#leaveTable");
		$(window).scrollTop( scrollToElement.offset().top);
		$("#update").attr("disabled",true);
		$("#reset").attr("disabled",true);
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
	$(".datafield").each(function(){
			var curInput = $(this).find(".medicalleave").find("input")	
	});
	$("#update").attr("disabled", true);
	$("#edit").removeAttr("disabled");
});
$("#reset").click(function(){
		location.reload();
});
</script>
