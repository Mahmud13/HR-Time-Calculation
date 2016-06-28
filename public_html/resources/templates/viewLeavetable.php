<article>
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
			<th>Casual/Sick Leave</th>
			<th>Medical Leave</th>
			<th>Earn Leave</th>
			<th>Enjoyed Leave</th>
			<th>Without Pay</th>
			<th>Balance Left</th>
		</tr>
		<?php foreach($days as $index=>$day): ?>
			<tr>
				<td class="date"><?php echo $day; ?></td>
				<td class="day"><?php echo date("l", strtotime("$year-$monthid-$day")); ?></td>
				<td class="stat"><?php if(isset($flags[$index])){echo strtoupper(substr($flags[$index],0,1));}else{echo "-";}?></td>
				<td class="intime" id="intime" value="10:55"><?php echo $intime[$day]; ?></td>
				<td class="outtime" id="outtime" value=<?php echo $intime[$day]; ?>><?php echo $outtime[$day]; ?></td>
				<td class="workhour"><?php echo  $workhour[$day]; ?></td>
				<td class="status"><?php echo isset($status[$day]) ? $status[$day] : "-"; ?></td>
				<td class="workhour"></td>
				<td class="workhour"></td>
				<td class="workhour"></td>
				<td class="workhour"></td>
				<td class="workhour"></td>
				<td class="workhour"></td>
			</tr>
		<?php endforeach;?>
	</table>
	<br><br>
</article>	
<script>
	$(document).ready( function(){
		var scrollToElement = $("#leaveTable");
		$(window).scrollTop( scrollToElement.offset().top);
	});
</script>