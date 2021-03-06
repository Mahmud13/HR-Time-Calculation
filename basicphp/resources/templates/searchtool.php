<script>
$(document).ready(function(){
	$("#staffpin").mousedown(function(){
		$("#searchnameholder").html("<option>dkk</option>");
	});
});	
</script>
<section>
	<form action="" method="post" id="search"> 
		<div name="department" id="department-list">
			<label>Department:</label>
			<select name="departmentid" id="departmentid" onChange="getStaff(this.value)">
				<option value = "">Select a department</option>
				<?php foreach ($departments as $dept): ?>
				<option value=<?php echo html($dept['id']) ?> <?php if (isset($_POST['departmentid']) and $_POST['departmentid']==$dept['id']) {echo "selected='selected'";} ?> ><?php echo html($dept['name']); ?></option>
				<?php endforeach; ?>
			</select>
			<br><br>
		</div>
		<div name="staff" id="staff-list" >
			<label>Staff name: </label>
			<select name="staffpin" id="staffpin" onChange="getYear(this.value)">
				<option value = "">Select Staff</option>
				<?php require LIBRARY_PATH . "/get_staff_raw.php";?>
						<?php foreach ($staff as $employee): ?>
							<option value=<?php echo $employee['pin']; ?> <?php if (isset($_POST['staffpin']) and $_POST['staffpin']==$employee['pin']) {echo "selected='selected'"; } ?> ><?php echo html($employee['name']); ?></option>
						<?php endforeach; ?>
			</select>
			
			<br><br>
		</div>
		<div name="staffbox" id="staff-pinbox" >
			<label>Staff pin: </label>
				<input oninput="getStaffName(this)" id="staffpinin" type="text" <?php if (isset($_POST['staffpin'])){echo "value=".$_POST['staffpin'];}else{echo "value=''"; echo "placeholder='PIN'";}?>>		
			<br><br>
		</div>
		<div name="year" id="year-list">
			<label>Year: </label>
			<select name="year" id="year" onChange="getMonth(this.value)">
				<option value = "">Select Year</option>
				<?php if (isset($_POST['year'])){
						require LIBRARY_PATH . "/get_year_raw.php";
						foreach ($years as $year): ?>
							<option value=<?php echo $year; ?> <?php if ($_POST['year']==$year) {echo "selected='selected'"; } ?> ><?php echo html($year); ?></option>
						<?php endforeach; ?>
				<?php	}
				?>	
			</select>
			<br><br>
		</div>	
		<div name="month" id="month-list">
			<label>Month: </label>
			<select name="month">
				<option value = "">Select Month</option>
				<?php if (isset($_POST['month'])){
						require LIBRARY_PATH . "/get_month_raw.php";
						foreach ($months as $month): ?>
							<option value=<?php echo $month; ?> <?php if ($_POST['month']==$month) {echo "selected='selected'"; } ?> ><?php echo html($month); ?></option>
						<?php endforeach; ?>
				<?php	}
				?>	
			</select>
		</div>	
			<br><br>
		
		<input type="hidden" name="autoMan" id="automan" >
		<input type="hidden" name="autoCal" id="autocal" >
		<button type="submit" value="viewTime"  id="search-submit1" name="action">Show time report</button>
		<button type="submit" value="viewLeave" id="searchsubmit2" name="action">Show leave report</button>
	</form>
</section>

<script>
$("#searchsubmit2").click(function(){
	$("#automan").val("0");
});
</script>

