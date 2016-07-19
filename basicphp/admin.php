<?php 
	require_once('resources/config.php');
	$pagetitle = "Admin Panel";
	require_once(TEMPLATES_PATH . "/header.php");
	require_once(TEMPLATES_PATH . "/nav.php");
?>
<section>
	<button id="modifyDept">Add/Modify Department</button>
	<button id="modifyStaff">Add/Modify Staff</button>
	<button id = "calendar"><a href="hr_calendar/index.php" target="_blank">Change calendar</a></button>
	<form>
		<div class="hideDefault" id="deptForm">
			<input type="text">
		</div>
		<div class="hideDefault" id="staffId">
			<label for="staff-pin">Enter the pin</label>
			<input type="number" name="staffpin">
			<button id="pinsearch">Search</button>
		</div>
	</form>
</section>
<Script>
	$("#modifyDept").click(function(){
		$("#staffId").hide();
		$("#deptForm").show();
	});
	$("#modifyStaff").click(function(){
		$("#deptForm").hide();
		$("#staffId").show();
	});	
	$("#pinsearch").click(function(){
		$.get("", function(data, status){
			alert("Data: " + data + "\nStatus: " + status);
		});
	});
	
</Script>
<?php
	require_once(TEMPLATES_PATH . "/footer.php");
?>
