<article>
	<table id="viewTable">
		<caption style="font-size: 1.5em;font-weight:bold;">Attendace Report</caption>
		<caption style="font-size: 1em;font-weight:bold;"><?php echo $month." ".$year;?></caption>
		<tr>
			<td colspan="3" style="text-align:left;border-top: 1px solid transparent;border-left: 1px solid transparent;border-right: 1px solid transparent"><b>Name: </b> <?php echo $staffname;?><br><b>Designation: </b><?php echo $designation; ?></td>
			<td colspan="2" style="text-align:right;border-top: 1px solid transparent;border-left: 1px solid transparent;border-right: 1px solid transparent"><b>Pin: </b><?php echo sprintf("%08d",$staffpin); ?></td>
		</tr>
		<tr>
			<th>Date</th>
			<th>Day</th>
			<th>Day Status</th>
			<th>In time</th>
			<th>Out time</th>
			
		</tr>
		<?php foreach($days as $index=>$day): ?>
			<tr>
				<td class="date"><?php echo $day; ?></td>
				<td class="day"><?php echo date("l", strtotime("$year-$monthid-$day")); ?></td>
				<td class="stat"><?php if(isset($flags[$index])){echo ucfirst($flags[$index]);}else{echo "-";}?></td>
				<td class="time"><?php echo $intime[$day]; ?></td>
				<td class="time"><?php echo $outtime[$day]; ?></td>
			</tr>
		<?php endforeach;?>
	</table>
	<br><br>
</article>
<script>
	$(document).ready( function(){
		var scrollToElement = $("#viewTable");
		$(window).scrollTop( scrollToElement.offset().top);
	});
</script>
