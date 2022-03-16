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
	} else {
		if(!isset($_SESSION['qaSubject'])){
			include "qaRowsGetSubject.php";
			$callExisting = new qaRowsGetSubject($dbh, $username);
			$callExisting->callMethods();
			# if this json is set, do not call teh next function. $callExisting->returnJson;
			include "qaRowsGetCurrent.php";
			$callExisting = new qaRowsGetCurrent($dbh, $username, $_SESSION['qaSubject']);
			$callExisting->callMethods();
			echo $callExisting->returnJson;
		} else {
			include "qaRowsGetCurrent.php";
			$callExisting = new qaRowsGetCurrent($dbh, $username, $_SESSION['qaSubject']);
			$callExisting->callMethods();
			echo $callExisting->returnJson;
		}
	}


	
		#Change to JSON response
?>
