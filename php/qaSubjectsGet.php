<?php
session_start();
include "pdo_ConStart.php";
# Delete qaRowsExisting.php?
# Implement $_SERVER["Request_URI"]

	if(isset($_SESSION['Username'])){
		$username = $_SESSION['Username'];
	} else {
		die("Error: Please try logging in again.");
	}

	if($_SESSION['Authorized'] != true){
		die("Error: Please try logging in again.");
	}


$callSubjects = new qaRowsGet($dbh, $username);
$callSubjects->callMethods();
echo $callSubjects->returnJson;


class qaRowsGet {

	public $returnJson;

	function __construct($dbh, $username) {
		$this->dbh = $dbh;
		$this->username = $username;
	}

	function callMethods() {
		$this->getSubjects();
	}

	function getSubjects(){
		$querySubjects = $this->dbh->query("SELECT DISTINCT subject FROM qarows WHERE 
			usr = '$this->username'");
		$querySubjects = $querySubjects->fetchAll(PDO::FETCH_COLUMN);
		natsort($querySubjects);
		$subjectsJson = json_encode($querySubjects);
		$this->returnJson = $subjectsJson;
	}
}





?>
