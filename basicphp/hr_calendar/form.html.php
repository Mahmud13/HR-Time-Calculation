<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Pristine Calendar</title>
	</head>
	<body>
	<form method="get" action="">
		<select name="year"> 
		<option value="">Select Year </option>
		<?php
		
		for($y=2015; $y<=2030; $y++)
		{
		?>
		<option value=<?php echo $y;?>><?php echo $y;?></option>
		<?php
		}
		?>
		</select>
		
		<select name="month"> 
		<option value="">Select Month </option>
		<?php
		
		for($m=1; $m<=12; $m++)
		{
		?>
		<option value=<?php echo $m;?>><?php echo date("F", strtotime("2016-$m-01"));?></option>
		<?php
		}
		?>
		</select>
		<input type="submit" value="View">
		</form>
	</body>
</html>
