<?php 
if(!isset($_GET["year"]) or !isset($_GET["month"])){
	include "form.html.php";
	exit();
}
include_once $_SERVER['DOCUMENT_ROOT'] . '/hrm/basicphp/hr_calendar/includes/db.inc.php';
$year = $_GET["year"];
$month = $_GET["month"];

$epochtime = strtotime("$year-$month-01");
$daycounter = date("d", $epochtime);
do{
	$days[] = $daycounter;
	$daycounter = date("d", strtotime("+1 day", $epochtime));
	$epochtime = strtotime("$year-$month-$daycounter");
	$sql = 'SELECT `flag`, `map`, `note` FROM calendar WHERE `epochdate`="'.$epochtime.'"';
	$result = mysqli_query($link, $sql);
	if(!$result){
		$error = "failed to collect".mysqli_error();
		include 'error.html.php';
		exit();
	}else{
		$row = mysqli_fetch_array($result);
		$flag[$daycounter] =  $row["flag"];
		$map[$daycounter] = $row["map"];
		$note[$daycounter] = $row["note"];
	}
	
}while($daycounter != 1);


foreach($days as $day):
if(!isset($_POST["flag$day"])){
echo "Please set the status of all flags";
include "output.html.php";
exit();
}
endforeach;

foreach($days as $day):
$ds = $_POST["flag$day"];
$ms = isset($_POST["map$day"]) ? $_POST["map$day"] : "";
$ns = isset($_POST["note$day"]) ? $_POST["note$day"] : "";
	if($flag[$day]==""){
	$sql = 'INSERT INTO calendar SET
			epochdate = "'.strtotime("$year-$month-$day").'",
			date = "'.$year.'-'.$month.'-'.$day.'",
			flag = "'.$ds.'",
			map = "'.$ms.'"
			note = "'.$ns.'"';

	if (!mysqli_query($link, $sql)){
		$error = 'Error saving: ' . mysqli_error($link);
		include 'includes/error.html.php';
		exit();
	}
	}else{
	$sql = 'UPDATE calendar SET
			flag = "'.$ds.'", map = "'.$ms.'", note = "'.$ns. '" 
			WHERE epochdate="'.strtotime("$year-$month-$day").'"';
	if (!mysqli_query($link, $sql)){
		$error = 'Error saving: ' . mysqli_error($link);
		include 'includes/error.html.php';
		exit();
	}
	}
endforeach;

echo "Succesfully saved calendar for ".date("F", $epochtime)." ".$year;
echo "<br><br><a href='index.php'><button>New Month</button></a>"


?>
