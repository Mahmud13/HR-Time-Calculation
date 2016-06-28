<?php
	include "../config.php";
	include LIBRARY_PATH . "/db.inc.php";
	$year = "2015";
	for($month=1;$month<=12;$month++)
	{
		$lastDayOfMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
		for($day=1;$day<=$lastDayOfMonth;$day++)
		{
			
		}
		echo "<br>";
	}
	echo date_parse('January');
?>
