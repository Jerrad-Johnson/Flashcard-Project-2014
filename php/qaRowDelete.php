<?php
session_start();
include "pdo_ConStart.php";

if(!isset($_POST['id'])){
	die("No ID was sent to the server. Did you already delete that row?");
	#JSON
}

if(!isset($_SESSION['Username'])){
	die("We couldn't find your username, please login again.");
	#JSON
}

$delete = new deleteRow($dbh, $_SESSION['Username'], $_POST['id']);
$delete->callMethods();


class deleteRow {

	function __construct($dbh, $username, $id){
		$this->dbh = $dbh;
		$this->username = $username;
		$this->id = $id;
	}

	function callMethods(){
		$this->checkDatabase();
	}

	function checkDatabase(){
		$check = $this->dbh->query("SELECT id FROM qarows WHERE usr='$this->username'");
		$check = $check->fetchAll(PDO::FETCH_COLUMN);
		if(in_array($this->id, $check)){
			$this->removeRow();
		} else {
			die("We couldn't find that row. Did you already delete it?");
		}
	}

	function removeRow(){
		$remove = $this->dbh->prepare("DELETE FROM qarows WHERE id=:id");
		$remove->bindParam(':id', $this->id);
		$remove->execute();
        $arr = ["returnInteger" => "$this->id"];
		echo json_encode($arr);

		#Add error reporting.
	}
}
