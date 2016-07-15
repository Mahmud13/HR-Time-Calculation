<?php
class Staff {
	private $staff_name;
	private $staff_pin;

	function __construct($staff_name="", $staff_pin=""){
		$this->staff_name = $staff_name;
		$this->staff_pin = $staff_pin;
	}
	function __tostring(){
		return "Name: ". $this->staff_name . " Pin: " . $this->staff_pin;
	}
}
		
?>
