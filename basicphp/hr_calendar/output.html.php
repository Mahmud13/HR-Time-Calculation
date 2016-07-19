<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Pristine Calendar</title>
		<style>
			table, th, td {
				border: 1px solid black;
				border-collapse: collapse;
			}
			th, td {
				padding: 5px;
			}
		</style>
		<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
		<script src="//code.jquery.com/jquery-1.10.2.js"></script>
		<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
		<link rel="stylesheet" href="/resources/demos/style.css">
		<script>
			$(function() {
				$( ".datepicker" ).datepicker({ dateFormat: "yy-mm-dd", defaultDate: "<?php echo $year.'-'.$month.'-1'; ?>"});
			});
		</script>
	</head>
	<body>
		<form method = "post", action = "">
			<table>
				<tr>
					<th>Date</th><th>Day</th><th>Flag</th><th>Map</th><th>Note</th>
				</tr>
				<?php foreach($days as $day): ?>
				<tr>
					<td><?php echo $year." - ".date("F", $epochtime)." - ".$day; ?></td>
					<td><?php $dayname = date("l", strtotime("$year-$month-$day")); echo $dayname; ?></td>
					<td>
						<input type="radio" name="flag<?php echo $day; ?>" value="workday" <?php if($flag[$day]=="workday" or ($flag[$day]!= "holiday" and $dayname != "Friday" and $dayname != "Saturday")){echo "checked='true'";} ?>>Workday
						<input type="radio" name="flag<?php echo $day; ?>" value="holiday" <?php if($flag[$day]=="holiday" or ($flag[$day]!= "workday" and ($dayname == "Friday" or $dayname == "Saturday"))){echo "checked='true'";} ?>>Holiday
					</td>
					<td> 
						<input type="text" name="map<?php echo $day; ?>" class="datepicker" value= "<?php if($map[$day]!='0000-00-00'){ echo $map[$day];} ?>"></td>
					<td>
						<input type="text" name="note<?php echo $day; ?>" value="<?php echo is_null($note[$day]) ? '' : $note[$day]; ?>">
					</td>
				</tr>
				<?php endforeach; ?>
			</table>
			<br>
			<input type = "submit" value = "Save">
		</form>

	</body>
</html>