<?php
//DB.class.php

class DB {

	protected $db_name = 'timedb';
	protected $db_user = 'timedbuser';
	protected $db_pass = 'helloyou';
	protected $db_host = 'localhost';
	private $link = "";
	//open a connection to the database. Make sure this is called
	//on every page that needs to use the database.
	public function connect() {
		$this->link = mysqli_connect($this->db_host, $this->db_user, $this->db_pass);
		if (!$this->link){
			return false;
		}
		if (!mysqli_set_charset($this->link, 'utf8')){
			return false;
		}
		if (!mysqli_select_db($this->link, $this->db_name)){
			return false;
		}
		return true;
	}

	//takes a mysql row set and returns an associative array, where the keys
	//in the array are the column names in the row set. If singleRow is set to
	//true, then it will return a single row instead of an array of rows.
	public function processRowSet($rowSet, $singleRow=false){
		$resultArray = array();
		while($row = mysqli_fetch_array($rowSet)){
			array_push($resultArray, $row);
		}

		if($singleRow === true)
			return $resultArray[0];

		return $resultArray;
	}

	//Select rows from the database.
	//returns a full row or rows from $table using $where as the where clause.
	//return value is an associative array with column names as keys.
	public function select($table, $where) {
		$sql = "SELECT * FROM $table WHERE $where";
		$result = mysqli_query($this->link, $sql);
		if(mysql_num_rows($result) == 1)
			return $this->processRowSet($result, true);

		return $this->processRowSet($result);
	}

	//Updates a current row in the database.
	//takes an array of data, where the keys in the array are the column names
	//and the values are the data that will be inserted into those columns.
	//$table is the name of the table and $where is the sql where clause.
	public function update($data, $table, $where) {
		$sql = "UPDATE $table SET ";
		foreach ($data as $column => $value) {
			$sql .= "$column = $value, ";
		}
		$sql = substr($sql, 0 , -2);
 		$sql .= " WHERE $where";
		mysqli_query($this->link, $sql) or die(mysqli_error($this->link));
		return true;
	}

	//Inserts a new row into the database.
	//takes an array of data, where the keys in the array are the column names
	//and the values are the data that will be inserted into those columns.
	//$table is the name of the table.
	public function insert($data, $table) {

		$columns = "";
		$values = "";

		foreach ($data as $column => $value) {
			$columns .= ($columns == "") ? "" : ", ";
			$columns .= $column;
			$values .= ($values == "") ? "" : ", ";
			$values .= $value;
		}

		$sql = "insert into $table ($columns) values ($values)";

		mysqli_query($this->link, $sql) or die(mysqli_error($this->link));

		//return the ID of the user in the database.
		return mysqli_insert_id($this->link);

	}

}

?>
